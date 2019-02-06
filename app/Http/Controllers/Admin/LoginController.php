<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * Method redirects to admin.dashboard if user authenticated and has permissions
     * or
     * returns a login form view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo(User::PERMISSION_ADMIN)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * Processes admin authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $login = $request->get('username');
        $pass = $request->get('password');
        if (
            Auth::attempt(['email' => $login, 'password' => $pass])
            &&
            Auth::user()->hasPermissionTo(User::PERMISSION_ADMIN)
        ) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back();
    }
}
