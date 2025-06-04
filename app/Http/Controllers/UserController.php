<?php

namespace App\Http\Controllers;

use App\Helpers\Auth\UserAuthenticationHelper;

class UserController extends Controller
{
    public function showDashboard()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        return view("pages.user.dashboard", [
            "role" => $currentRole
        ]);
    }

    public function showProfile()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        return view("pages.user.profile", [
            "role" => $currentRole
        ]);
    }
}
