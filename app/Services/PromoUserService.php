<?php

namespace App\Services;


use App\Models\Activations;
use App\Models\PromoUser;
use App\Models\Promocode;
use Carbon\Carbon;

class PromoUserService
{
    /**
     * Промо-юзер
     *
     * @var PromoUser|null
     */
    private $promoUser = null;

    /**
     * Промомкоды промо-юзера
     *
     * @var mixed|null
     */
    private $promoUserPromocodes = null;

    /**
     * Текущая дата
     *
     * @var Carbon|null
     */
    private $now = null;

    /**
     * Сообщение с текстом ошибки
     *
     * @var null
     */
    private $message = null;

    /**
     * PromoUserService constructor.
     * @param PromoUser $promoUser
     */
    public function __construct(PromoUser $promoUser = null)
    {
        if (!is_null($promoUser)) {
            $this->setPromoUser($promoUser);
        }
        $this->now = Carbon::now();
    }

    /**
     * Активировать промокод
     *
     * @param Promocode $promocode
     * @return bool
     */
    public function activatePromocode(Promocode $promocode) : bool
    {
        if ($this->checkPromocodeBeforeActivate($promocode)) {
            $this->promoUser->promocodes()->attach($promocode->id);
            $promocode->increment('used');
            return true;
        }
        return false;
    }

    /**
     * Деактивировать промокод
     *
     * @param Promocode $promocode
     * @return bool
     */
    public function deactivatePromocode(Promocode $promocode) : bool
    {
        $exists = $this->promoUserPromocodes->where('id', $promocode->id)->first();
        if (is_null($exists)) {
            $this->setMessage('Промокод не был применен.');
            return false;
        }
        return true;
    }

    /**
     * Проверить промокод перед активацией
     *
     * @param Promocode $promocode
     * @return bool
     */
    public function checkPromocodeBeforeActivate(Promocode $promocode) : bool
    {
        if ($this->now > $promocode->release_end) {
            $this->setMessage('Промокод не действителен.');
            return false;
        }
        if ($promocode->used === $promocode->limit) {
            $this->setMessage('Промокод невозможно выбрать. Количество ограничено.');
            return false;
        }
        if (!is_null($this->promoUserPromocodes)) {
            $exists = $this->promoUserPromocodes->where('id', $promocode->id)->first();
            if (!is_null($exists)) {
                $this->setMessage('Промокод уже применен.');
                return false;
            }
        }
        return true;
    }

    /**
     * @param $message
     */
    private function setMessage(string $message) : void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Создать промо-юзера
     *
     * @param array $data
     * @return PromoUser
     */
    public function create(array $data) : PromoUser
    {
        $oPromoUser = PromoUser::create([
            'name' => $data['name'],
            'user_id' => $data['user_id'],
            'phone' => $data['phone'],
        ]);
        return $oPromoUser;
    }

    /**
     * Обновить промо-юзера
     *
     * @param $id
     * @param array $data
     * @return PromoUser
     */
    public function update($id, array $data) : PromoUser
    {
        $oPromoUser = PromoUser::find($id);
        $oPromoUser->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        return $oPromoUser;
    }

    /**
     * @param PromoUser $promoUser
     */
    public function setPromoUser(PromoUser $promoUser)
    {
        $this->promoUser = $promoUser;
        $this->promoUserPromocodes = $promoUser->promocodes;
    }

    /**
     * Генерация и отправка кода подтверждения на телефон
     *
     * @param int $phone
     * @return int
     */
    public function codeGenerateByPhone(int $phone) : int
    {
        $existsCodes = Activations::where('phone', $phone)
            ->where('completed', 0)
            ->get();
        if (count($existsCodes) !== 0) {
            foreach ($existsCodes as $oActivation) {
                $oActivation->delete();
            }
        }
        $oCodeService = new Code();
        $code = $oCodeService->getConfirmationPromoCode();
        Activations::create([
            'phone' => $phone,
            'code' => $code,
        ]);
        $oCodeService->sendConfirmationPromoCode($code);
        return $code;
    }

    /**
     * Проверка кода подтверждения по телефону
     *
     * @param $phone
     * @param $code
     * @return bool
     */
    public function codeCheckByPhone(int $phone, int $code) : bool
    {
        $oActivation = Activations::where('code', $code)
            ->where('phone', $phone)
            ->where('completed', 0)
            ->first();
        if (is_null($oActivation)) {
            return false;
        }
        $oActivation->update([
            'completed' => 1
        ]);
        return true;
    }
}
