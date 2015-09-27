<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Notification extends Entity {

    public function user(){
        return $this->belongsTo(User::getClass());
    }

}
