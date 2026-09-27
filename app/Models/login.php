<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class login extends Authenticatable
{
use HasApiTokens, HasFactory, Notifiable, HasUuids;    protected $table = 'login';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable =[
        'username',
        'email',
        'password',
        'otp_code',
    'otp_expires_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
