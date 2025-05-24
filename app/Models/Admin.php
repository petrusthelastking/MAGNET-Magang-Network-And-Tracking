<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Admin extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;

    protected $table = 'admin';

    protected $fillable = [
        'nama',
        'nip',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getRoleName(): string
    {
        return 'admin';
    }
}
