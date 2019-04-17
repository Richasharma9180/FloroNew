<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthenticationLog extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 'ip_address', 'login_time','logout_time','agent'
    ];
}

