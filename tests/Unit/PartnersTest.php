<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Release;
use App\Journal;
use App\Quota;
use App\Partner;
use App\PartnerUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

//use DB;
class PartnersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    //Тесты по партнёрам
    public function testCreatePartner()
    {
        for ($i=0; $i < 10; $i++) {
            Partner::create(['secret_key' => md5(rand(0,999999)), 'active' => rand(0,1)]);
        }
        $this->assertTrue(true);
    }
    public function testGetUsers()
    {
        $partner = Partner::inRandomOrder()->get()->first();
        $this->assertTrue(true);
    }
    //Тесты по юзерам партнёров
    public function testCreatePartnerUsers()
    {
        for ($i=0; $i < 10; $i++) {
            $partner = Partner::inRandomOrder()->get()->first();
            PartnerUser::create(['user_id' => md5(rand(0,999999)), 'active' => rand(0,1), 'partner_id' => $partner->id]);
        }
        $this->assertTrue(true);
    }
    public function testGetPartnerByUser()
    {
        $user = PartnerUser::inRandomOrder()->get()->first();
        $this->assertTrue(true);
    }
    public function testGetPartnerUsersQuotas()
    {
        $user = PartnerUser::find(6);
        dump($user->quotas);
        $this->assertTrue(true);
    }
    public function testSetPartnerUsersQuotas()
    {
        $user = PartnerUser::where('active', 1)->inRandomOrder()->first();
        $quota = Quota::where('active', 1)->where('partner_id', $user->partner_id)->inRandomOrder()->first();
        if ($quota)
            dump($user->useQuota($quota->id));
        $this->assertTrue(true);
    }
    public function testSetPartnerUsersReleases()
    {
        $user = PartnerUser::where('active', 1)->inRandomOrder()->first();
        $releases = Release::inRandomOrder()->limit(10)->get();
        foreach ($releases as $release) {
            if (!$user->releases()->find($release->id))
                $user->releases()->save($release);
        }
        foreach ($user->releases as $release)
            dump($release->name);
        $this->assertTrue(true);
    }
    //Тест по статусам партнёров и их пользователям
    public function testCheckActiveStatus()
    {
        for ($i=0; $i < 10; $i++) {
            $partner = Partner::inRandomOrder()->get()->first();
            dump($partner->isActive());
            dump($partner->users->count());
            foreach ($partner->users as $user) {
                dump($user->isActive());
            }
        }
        $this->assertTrue(true);
    }
    ////Тесты по квотам
    public function testCreateQuotas()
    {
        for ($i=0; $i < 100; $i++) {
            $newQuata = ['active' => mt_rand(0,1)];
            $partner = Partner::inRandomOrder()->get()->first();
            $newQuata['partner_id'] = $partner->id;
            if (mt_rand(0,1)) {
                $newQuata['journal_id'] = Journal::inRandomOrder()->get()->first()->id;
                if (mt_rand(0,1)) {
                    $newQuata['release_begin'] = '2018-'.mt_rand(1,6).'-'.mt_rand(1,28).' 00:00:00';
                    $newQuata['release_end'] = '2018-'.mt_rand(7,12).'-'.mt_rand(1,30).' 00:00:00';
                }
            }
            if (mt_rand(0,1) || empty($newQuata['journal_id'])) {
                if (empty($newQuata['journal_id']))
                    $newQuata['release_id'] = Release::inRandomOrder()->get()->first()->id;
                else
                    $newQuata['release_id'] = Release::where('journal_id', $newQuata['journal_id'])->inRandomOrder()->get()->first()->id;
            }
            $newQuata['quota_size'] = mt_rand(1,99);
            Quota::create($newQuata);
        }
        $this->assertTrue(true);
    }
    public function testGetQuotasReleases()
    {
        //DB::enableQueryLog();
        //$quota = Quota::find(26);
        $quota = Quota::inRandomOrder()->first();
        dump($quota->id);
        dump($quota->getReleases()->count());
        //dd(DB::getQueryLog());
        $this->assertTrue(true);
    }
}
