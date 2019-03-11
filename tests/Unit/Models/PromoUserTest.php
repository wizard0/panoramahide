<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Дмитрий Поскачей (dposkachei@gmail.com)
 */
namespace Tests\Unit\Models;

use App\Models\Journal;
use App\Models\JbyPromo;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Models\Publishing;
use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class for promo user test.
 */
class PromoUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var User
     */
    private $user;

    /**
     * @var PromoUser
     */
    private $promoUser;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->promoUser = factory(PromoUser::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @covers \App\Models\PromoUser::setPhoneAttribute()
     */
    public function testSetPhoneAttribute()
    {
        $oldPhone = $this->promoUser->phone;

        $this->promoUser->update([
            'phone' => '+7 (999) 888-77-66'
        ]);

        $newPhone = $this->promoUser->phone;
        $this->assertTrue($oldPhone !== $newPhone);
    }

    /**
     * @covers \App\Models\PromoUser::user()
     */
    public function testUser()
    {
        $this->assertTrue($this->promoUser->user instanceof User);
    }

    /**
     * @covers \App\Models\PromoUser::promocodes()
     */
    public function testPromocodes()
    {
        $oPromocode = factory(Promocode::class)->create();

        $this->promoUser->promocodes()->attach($oPromocode->id);

        $oPromocode = $this->promoUser->promocodes->first();
        $this->assertTrue($oPromocode instanceof Promocode);
    }

    /**
     * @covers \App\Models\PromoUser::publishings()
     */
    public function testPublishings()
    {
        $oPublishing = factory(Publishing::class)->create();

        $this->promoUser->publishings()->attach($oPublishing->id);

        $oPromocode = $this->promoUser->publishings->first();
        $this->assertTrue($oPromocode instanceof Publishing);
    }

    /**
     * @covers \App\Models\PromoUser::releases()
     */
    public function testReleases()
    {
        $oJournal = factory(Journal::class)->create();
        $oRelease = factory(Release::class)->create([
            'journal_id' => $oJournal->id,
        ]);

        $this->promoUser->releases()->attach($oRelease->id);

        $oRelease = $this->promoUser->releases->first();
        $this->assertTrue($oRelease instanceof Release);
    }

    /**
     * @covers \App\Models\PromoUser::jByPromo()
     */
    public function testJByPromo()
    {
        $oPromocode = factory(Promocode::class)->create();
        $oJournal = factory(Journal::class)->create();

        $oJbyPromo = JbyPromo::create([
            'promo_user_id' => $this->promoUser->id,
            'promocode_id' => $oPromocode->id,
        ]);
        $oJbyPromo->journals()->attach($oJournal->id);

        $oJournal = $oJbyPromo->journals->first();
        $this->assertTrue($oJournal instanceof Journal);

        $oJbyPromo = $this->promoUser->jByPromo()->where('promocode_id', $oPromocode->id)->first();
        $this->assertTrue($oJbyPromo instanceof JbyPromo);
    }

    /**
     * @covers \App\Models\PromoUser::jByPromocodes()
     */
    public function testJByPromocodes()
    {
        $oPromocode = factory(Promocode::class)->create();

        $this->promoUser->jByPromocodes()->attach($oPromocode->id);

        $oPromocode = $this->promoUser->jByPromocodes->first();
        $this->assertTrue($oPromocode instanceof Promocode);
    }
}
