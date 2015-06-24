<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;
class Notification extends Entity {

    public function user(){
        return $this->belongsTo(User::getClass());
    }

}
