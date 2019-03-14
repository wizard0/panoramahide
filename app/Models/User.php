<?php

namespace App\Models;

use App\Models\PromoUser;
use App\Models\Order;
use App\Models\OrderedSubscription;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\Traits\UserBookmarks;
use App\Models\Traits\UsersDevices;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

/**
 * @property string $name
 * @property string $last_name
 * @property string $phone
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use UsersDevices;
    use UserBookmarks;

    const PERMISSION_ADMIN = 'web admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERADMIN = 'super-admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'private', 'name', 'last_name', 'second_name', 'email', 'phone', 'password', 'gender', 'version', 'agree', 'birthday', 'notes', 'country', 'title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'birthday'
    ];

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = Carbon::parse($value);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function searches(): Relation
    {
        return $this->hasMany(UserSearch::class);
    }

    public function promo(): Relation
    {
        return $this->hasOne(PromoUser::class, 'user_id');
    }

    public function getPhoneFormatAttribute(): string
    {
        return phoneFormat($this->phone);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }

    // Заказы пользователя
    public function orders()
    {
        $physUsers  = OrderPhysUser::whereUserId($this->id)->pluck('id')->toArray();
        $legalUsers = OrderLegalUser::whereUserId($this->id)->pluck('id')->toArray();
        $orders     = Order::where(function ($query) use ($physUsers, $legalUsers) {
                                $query->whereIn('phys_user_id', $physUsers)
                                      ->orWhereIn('legal_user_id', $legalUsers);
        });

        return $orders;
    }
    // Подписки пользователя
    public function getSubscriptions($sort = ['type' => 'asc'])
    {
        $subscriptions = OrderedSubscription::whereHas('order', function ($query) {
                            $query->where('status', 'completed')
                                  ->whereIn('order_id', $this->orders()->get()->pluck('id'));
        });
        $subscriptions = $subscriptions->orderBy('type', $sort['type']);

        return $subscriptions->get();
    }
    // Выпуски доступные пользователю по заказам/промокодам
    public function getReleases()
    {
        // Получаем выпуски пользователя доступные по заказам
        $releases = Release::whereHas('order', function ($query) {
            $query->where('status', 'completed')
                  ->whereIn('order_id', $this->orders()->get()->pluck('id'));
        })->orWhereHas('promoUser', function ($q) {
        // Получаем выпуски пользователя доступные по промокодам
            $q->whereHas('user', function ($q) {
                $q->where('id', $this->id);
            });
        })->orderBy('active_date', 'desc');

        return $releases->get();
    }

    public static function createNew($data)
    {
        return self::create([
            'role_id' => 2,
            'private' => isset($data['uf']['private_person']) ? 1 : 0,
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => preg_replace('/[^0-9]/', '', $data['phone']),
            'password' => Hash::make($data['password']),
        ]);
    }
}
