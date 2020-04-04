<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $table = 'password_resets';
    public $timestamps = false;
    
    public function getUser()
    {
        return $this->hasOne('App\Models\User', 'email', 'email');
    }
}

