<?php

namespace App\Http\Controllers;

use App\Helpers\UserAuthenticationHelper;

class UserController extends Controller
{
    public function showDashboard()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        return view("pages.$currentRole.dashboard");
    }

    public function showProfile()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        return view("pages.user.profile", [
            "role" => $currentRole
        ]);
    }
}
