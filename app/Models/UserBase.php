<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

abstract class UserBase extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    abstract public function getRoleName();
}
