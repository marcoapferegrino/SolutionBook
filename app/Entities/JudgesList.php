<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class JudgesList extends Entity {

<<<<<<< HEAD
    public function user(){
        return $this->belongsTo(Problem::getClass());
    }
=======
	 public function user(){
        return $this->belongsTo(Problem::getClass());
    }

>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178

}
