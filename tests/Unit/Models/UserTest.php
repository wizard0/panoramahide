<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Денис Парыгин (dyp2000@mail.ru)
 */
namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Carbon\Carbon;

class UserTest extends TestCase
{

    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = new User();
    }

    protected function tearDown()
    {
        unset($this->user);
    }

    /**
     * Тест установки даты рождения
     */
    public function testSetBirthdayAttribute()
    {
        $this->user->setBirthdayAttribute('1973-07-07');
        $dt = $this->user->getAttributeValue('birthday');
        $this->assertEquals('1973-07-07', $dt->format('Y-m-d'));
    }

    public function testGetPhoneFormatAttribute()
    {
        $this->user->setAttribute('phone', '79123456789');
        $this->assertEquals('+7 (912) 345-67-89', $this->user->getPhoneFormatAttribute());
    }

    public function testIsAdmin()
    {
        $user = User::where('email', 'admin')->first()
            ?? $user = factory(User::class)->create([
                'email' => 'admin',
                'password' => bcrypt('admin')
            ])->assignRole(User::ROLE_SUPERADMIN);

        $this->assertTrue($user->isAdmin('super-admin'));
    }
}
