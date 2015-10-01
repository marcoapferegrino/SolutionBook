<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

class Notification extends Entity {

    public function user(){
        return $this->belongsTo(User::getClass());
    }

}
