<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;

class Tag extends Entity {

<<<<<<< HEAD
    protected $fillable = ['name'];


    public function problem(){
        return $this->belongsToMany(Problem::getClass(),'problem_tag'); // pertenece a muchos problemas
=======
	
public function problem(){
        return $this->belongsToMany(Problem::getClass()); // pertenece a muchos problemas
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178
    }

}
