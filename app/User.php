<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserActivity;
use App\Models\AuthenticationLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
use HasApiTokens, Notifiable;
use SoftDeletes;
use Sortable;

/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
'username', 'first_name', 'last_name', 'email', 'password','address', 
'house_number', 'postal_code','city', 'telephone_number', 'is_active',
];

public $sortable=['id','username','first_name','last_name','created_at','updated_at'];

protected $hidden = [
'password', 'remember_token',
];

protected $dates = ['deleted_at'];

protected $casts = [
'email_verified_at' => 'datetime',
];

public function twoFactorAuth()
{
return $this->hasOne(TwoFactorAuth::class);
}


public function twoFactorAuthBackups()
{
return $this->hasMany(TwoFactorBackup::class);
}


public function userHistory()
{
return $this->MorphMany(UserActivity::class, 'entity')->with('modifiedBy')
->orderBy('updated_at', 'desc');
}


public function userLastLoginDetails()
{
return $this->hasMany(AuthenticationLog::class)->orderBy('created_at', 'desc')->limit(1);
}
}