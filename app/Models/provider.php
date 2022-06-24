<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;

class provider extends Authenticatable
{
    use HasFactory , HasApiTokens;

    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    protected $hidden=['password'];
}
