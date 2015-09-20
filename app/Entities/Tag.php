<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;

class Tag extends Entity {

	
public function problem(){
        return $this->belongsToMany(Problem::getClass()); // pertenece a muchos problemas
    }

}
