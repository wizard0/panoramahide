<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */
namespace App\Models;

use App\Cart;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use Chelout\Robokassa\Robokassa;
use Lexty\Robokassa\Payment;

class Order extends Model
{
    protected $table        = "orders";
    protected $fillable     = ['status'];
    protected $customFields = [];

    const PHYSICAL_USER = 'physical';
    const LEGAL_USER = 'legal';

    const STATUS_WAIT = 'wait';
    const STATUS_PAYED = 'payed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    public static $translate = [
        'txtstatus' => [
            self::STATUS_WAIT => 'Ожидает оплаты',
            self::STATUS_PAYED => 'Оплачен',
            self::STATUS_CANCELLED => 'Отменён',
            self::STATUS_COMPLETED => 'Завершён',
        ],
        'version' => [
            Subscription::TYPE_PRINTED => [
                Cart::PRODUCT_TYPE_RELEASE => 'Печатный выпуск',
                Cart::PRODUCT_TYPE_ARTICLE => 'Печатная статья',
                Cart::PRODUCT_TYPE_SUBSCRIPTION => 'Печатная подписка',
            ],
            Subscription::TYPE_ELECTRONIC => [
                Cart::PRODUCT_TYPE_RELEASE => 'Электронный выпуск',
                Cart::PRODUCT_TYPE_ARTICLE => 'Электронная статья',
                Cart::PRODUCT_TYPE_SUBSCRIPTION => 'Электронная подписка',
            ],
        ],
    ];

    public function __get($name)
    {
        if (isset($this->customFields[$name]))
            return $this->customFields[$name];

        switch ($name) {
            case 'txtstatus':
                $this->customFields[$name] = self::$translate['txtstatus'][$this->status];
                break;
            case 'date':
                $this->customFields[$name] = date('d.m.Y', strtotime($this->created_at));
                break;
            case 'items':
                $this->customFields[$name] = $this->getItems();
                break;
            default:
                return parent::__get($name);
                break;
        }

        return $this->customFields[$name];
    }

    public function getItems()
    {
        $items = json_decode($this->orderList);
        foreach ($items as &$item) {
            switch ($item->type) {
                case Cart::PRODUCT_TYPE_ARTICLE :
                    $item->image = $item->product->image;
                    $item->route = route('article', $item->product->code);
                    break;
                case Cart::PRODUCT_TYPE_RELEASE:
                    $item->image = $item->product->image;
                    $item->route = route('journal', $item->product->journal->code);
                    break;
                case Cart::PRODUCT_TYPE_SUBSCRIPTION:
                    $item->image = $item->product->journal->image;
                    $item->route = route('journal', $item->product->journal->code);
                    break;
            }
            $item->typeVers    = self::typeVers($item->version, $item->type);
            $item->start_month = property_exists($item->product, 'start_month') ? $item->product->start_month : null;
        }
        return $items;
    }

    public static function typeVers($version, $type)
    {
        return self::$translate['version'][$version][$type];
    }

    public function paysystem()
    {
        return $this->belongsTo(Paysystem::class);
    }

    public function story()
    {
        return $this->hasMany(OrderStory::class);
    }

    public function user()
    {
        if (isset($this->phys_user_id) && $this->phys_user_id) {
            return $this->belongsTo(OrderPhysUser::class, 'phys_user_id');
        } else {
            return $this->belongsTo(OrderLegalUser::class, 'legal_user_id');
        }
    }


    public function release()
    {
        return $this->belongsToMany(Release::class, 'order_product', 'order_id', 'release_id');
    }

    public function article()
    {
        return $this->belongsToMany(Article::class, 'order_product', 'order_id', 'article_id');
    }

    public function subscription()
    {
        return $this->belongsToMany(OrderedSubscription::class, 'order_product', 'order_id', 'subscription_id');
    }

    public function getFullUserName()
    {
        return $this->user->getFullName();
    }

    public function getDeliveryAddress()
    {
        return $this->user->getDeliveryAddress();
    }

    public function getDate()
    {
        return date_format(date_create($this->created_at), "d.m.Y");
    }

    public function collectPayData()
    {
        switch ($this->paysystem->code) {
            case Paysystem::ROBOKASSA:
                $dataset = $this->paysystem->getDataValues();
                $signature = md5(
                    $dataset->shop_login .
                    ":" . $this->totalPrice .
                    ":" . $this->id .
                    ":" . $dataset->shop_pass .
                    ":Shp_item=1"
                );
                $robo = new Robokassa();
                $robo->setId($this->id);
                $robo->setSum($this->totalPrice);
                $robo->setCulture(Payment::CULTURE_RU);
                $robo->setPaymentMethod('RUR');
                $robo->setDescription('test');

                return (object)[
//                        'type' => $this->paysystem->code,
                    'description' => $this->paysystem->description,
                    'login' => $dataset->shop_login,
                    'signature' => $signature,
                    'paymentUrl' => $robo->getPaymentUrl()
                ];

            case Paysystem::SBERBANK:
                return (object)[
//                        'type' => $this->paysystem->code,
                    'description' => $this->paysystem->description,
                ];
            case Paysystem::INVOICE:
                break;
        }
    }

    public function saveOrder($data)
    {
        switch ($data['PERSON_TYPE']) {
            case Order::PHYSICAL_USER:
                $physUser = OrderPhysUser::create($data);

                $this->assocWithUser($physUser);

                $this->phys_user_id = $physUser->id;
                $this->paysystem()->associate(Paysystem::getByCode($data['paysystem_physic']));
                break;

            case Order::LEGAL_USER:
                $legalUser = OrderLegalUser::create($data);

                $this->assocWithUser($legalUser);

                $this->legal_user_id = $legalUser->id;
                $this->paysystem()->associate(Paysystem::getByCode($data['paysystem_legal']));
                break;
        }

        $this->orderList = json_encode(Session::get('cart')->items);
        $this->totalPrice = Session::get('cart')->totalPrice;
        $this->save();
    }

    private function assocWithUser($model)
    {
        // Создаём пользователя, если email указанный при оформлении - отсутствует
        if (!$user = User::where(['email' => $model->email])->first()) {
            $password = str_random(8);
            $model->user()->associate(User::createNew([
                'name'      => $model->name,
                'email'     => $model->email,
                'last_name' => $model->surname,
                'phone'     => $model->phone,
                'password'  => $password,
            ]))->save();
            // Высылаем на почту пароль
            \Mail::to($model->email)->send(new \App\Mail\Registration($model->email, $password));
            // Авторизуем пользователя
            Auth::login($model->user, true);
        } else {
            $model->user()->associate($user)->save();
        }
    }

    public function approve()
    {
        if ($this->status === Order::STATUS_COMPLETED)
            return false;
        $items = json_decode($this->orderList);
        foreach ($items as $item) {
            switch ($item->type) {
                case Cart::PRODUCT_TYPE_ARTICLE :
                    $this->article()->attach($item->product->id);
                    break;
                case Cart::PRODUCT_TYPE_RELEASE:
                    $this->release()->attach($item->product->id);
                    break;
                case Cart::PRODUCT_TYPE_SUBSCRIPTION:
                    $this->subscription()->attach($item->product->id);
                    break;
            }
        }
        $this->update(['status' => Order::STATUS_COMPLETED]);
        return true;
    }
}
