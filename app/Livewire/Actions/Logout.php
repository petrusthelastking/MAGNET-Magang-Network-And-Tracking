<?php

namespace App\Livewire\Actions;

use App\Helpers\UserAuthenticationHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        Auth::guard(UserAuthenticationHelper::getUserRole())->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
