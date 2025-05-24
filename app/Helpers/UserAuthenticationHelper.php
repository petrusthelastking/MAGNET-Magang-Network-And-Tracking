<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class UserAuthenticationHelper
{
    public static function getUserRole()
    {
        foreach (['admin', 'dosen', 'mahasiswa'] as $role) {
            if (Auth::guard($role)->check()) {
                return Auth::guard($role)->user()->getRoleName();
            }
        }

        return 'guest';
    }
}
