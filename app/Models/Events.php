<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Events extends Model
{
    public function user(){
        return $this->belongsToMany(User::class,'events_users');
    }
}