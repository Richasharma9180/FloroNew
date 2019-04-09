<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'id', 'entity_id','entity_type','old_value','new_value','field_name','modified_by'
        ];
        

    public $incrementing = false;


    
    public function entity()
    {
        return $this->morphTo();
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}

   