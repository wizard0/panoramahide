<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use Chelout\Robokassa\Robokassa;
use Lexty\Robokassa\Payment;


class Order extends Model
{
    protected $table = "orders";

    const PHYSICAL_USER = 'physical';
    const LEGAL_USER = 'legal';

    const STATUS_WAIT = 'wait';
    const STATUS_PAYED = 'payed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

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

    public function saveOrder($data) {
        switch ($data['PERSON_TYPE']) {
            case Order::PHYSICAL_USER:
                $physUser = OrderPhysUser::create($data);

                $this->assocWithUser($physUser, $data['name'], $data['email']);

                $this->phys_user_id = $physUser->id;
                $this->paysystem()->associate(Paysystem::getByCode($data['paysystem_physic']));
                break;

            case Order::LEGAL_USER:
                $legalUser = OrderLegalUser::create(data);

                $this->assocWithUser($legalUser, $data['l_name'], $data['l_email']);

                $this->legal_user_id = $legalUser->id;
                $this->paysystem()->associate(Paysystem::getByCode($data['paysystem_legal']));
                break;
        }

        $this->orderList = json_encode(Session::get('cart')->items);
        $this->totalPrice = Session::get('cart')->totalPrice;
        $this->save();
    }

    private function assocWithUser($model, $name, $email)
    {
        if (!$user = User::where(['email' => $email])->first()) {
            $model->user()->associate(User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(str_random())
            ]))->save();

            Auth::login($model->user, true);
        } else {
            $model->user()->associate($user)->save();
        }
    }
}
