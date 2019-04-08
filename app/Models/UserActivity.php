<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
  
  
    public $incrementing = false;
    
    protected $fillable = [
        'id', 'user_id','old_value','new_value','field_name','modified_by'
        ];
        
}
