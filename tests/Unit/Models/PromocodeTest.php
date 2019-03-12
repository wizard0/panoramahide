<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Дмитрий Поскачей (dposkachei@gmail.com)
 */
namespace Tests\Unit\Models;

use App\Models\Journal;
use App\Models\Group;
use App\Models\JbyPromo;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Models\Publishing;
use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for promocode test.
 */
class PromocodeTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

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
     * @covers \App\Models\Promocode::journals()
     */
    public function testJournals()
    {
        $oJournal = $this->factoryJournal();
        $oPromocode = $this->factoryPromocode();

        $countBefore = $oPromocode->journals()->count();
        $oPromocode->journals()->attach($oJournal->id);
        $countAfter = $oPromocode->journals()->count();
        $this->assertTrue($countAfter > $countBefore);

        $oFirst = $oPromocode->journals()->first();
        $this->assertTrue($oFirst instanceof Journal);
    }

    /**
     * @covers \App\Models\Promocode::jByPromo()
     */
    public function testJByPromo()
    {
        $oPromocode = $this->factoryPromocode();
        $countBefore = $oPromocode->jByPromo()->count();

        JbyPromo::create([
            'promo_user_id' => $this->promoUser->id,
            'promocode_id' => $oPromocode->id,
        ]);

        $countAfter = $oPromocode->jByPromo()->count();
        $this->assertTrue($countAfter > $countBefore);

        $oFirst = $oPromocode->jByPromo()->first();
        $this->assertTrue($oFirst instanceof JbyPromo);
    }

    /**
     * @covers \App\Models\Promocode::journal()
     */
    public function testJournal()
    {
        $oJournal = $this->factoryJournal();
        $oPromocode = $this->factoryPromocode([
            'journal_id' => $oJournal->id,
        ]);

        $this->assertTrue($oPromocode->journal instanceof Journal);
    }

    /**
     * @covers \App\Models\Promocode::publishings()
     */
    public function testPublishings()
    {
        $oPublishiing = $this->factoryPublishing();
        $oPromocode = $this->factoryPromocode();

        $countBefore = $oPromocode->publishings()->count();
        $oPromocode->publishings()->attach($oPublishiing->id);
        $countAfter = $oPromocode->publishings()->count();
        $this->assertTrue($countAfter > $countBefore);

        $oFirst = $oPromocode->publishings()->first();
        $this->assertTrue($oFirst instanceof Publishing);
    }

    /**
     * @covers \App\Models\Promocode::releases()
     */
    public function testReleases()
    {
        $oRelease = $this->factoryRelease();
        $oPromocode = $this->factoryPromocode();

        $countBefore = $oPromocode->releases()->count();
        $oPromocode->releases()->attach($oRelease->id);
        $countAfter = $oPromocode->releases()->count();
        $this->assertTrue($countAfter > $countBefore);

        $oFirst = $oPromocode->releases()->first();
        $this->assertTrue($oFirst instanceof Release);
    }

    /**
     * @covers \App\Models\Promocode::groups()
     */
    public function testGroups()
    {
        $oPromocode = $this->factoryPromocode();
        $countBefore = $oPromocode->groups()->count();

        Group::create([
            'promocode_id' => $oPromocode->id,
            'name' => 'Группа'
        ]);

        $countAfter = $oPromocode->groups()->count();
        $this->assertTrue($countAfter > $countBefore);

        $oFirst = $oPromocode->groups()->first();
        $this->assertTrue($oFirst instanceof Group);
    }
}
