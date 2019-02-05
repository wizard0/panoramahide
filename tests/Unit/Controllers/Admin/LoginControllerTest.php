<?php

namespace Tests\Unit\Controllers\Admin;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testing default admin route '/' as
     * - unauthenticated user
     * - authenticated user
     * - admin user
     *
     */
    public function testAdminPage()
    {
        $user = factory(User::class)->create();
        $admin = factory(User::class)
            ->create()
            ->assignRole('admin');

        $responseNoUser = $this->get(route('admin'));
        $responseNoAdmin = $this->actingAs($user)->get(route('admin'));
        $responseAdmin = $this->actingAs($admin)->get(route('admin'));

        $responseNoUser->assertRedirect(route('admin.login'));
        $responseNoAdmin->assertRedirect(route('admin.login'));
        $responseAdmin->assertOk();
    }

    public function testLoginAction()
    {
        $user = factory(User::class)->create();
        $admin = factory(User::class)
            ->create()
            ->assignRole('admin');

        $responseNoAdmin = $this->post(route('admin.login'), [
            'username' => $user->email,
            'password' => 'secret'
        ]);
        $responseAdmin = $this->post(route('admin.login'), [
            'username' => $admin->email,
            'password' => 'secret'
        ]);

        $responseAdmin->assertRedirect(route('admin.dashboard'));
        $responseNoAdmin->assertRedirect();
    }
}
