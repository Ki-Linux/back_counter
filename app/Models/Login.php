<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class Login extends Authenticatable
{
   // use HasFactory;
   use HasApiTokens, HasFactory, Notifiable;

    protected $table = "login";
    protected $fillable = [
        'mail', 'username', 'password', 'random',
    ];
}
