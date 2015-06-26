<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;
class Solution extends Entity {


    /**
     * Esta es la relacion de muchos a muchos de los Likes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likesDeUsuarios()
    {
        return $this->belongsToMany(User::getClass());
    }

    public function codeSolution()
    {
    	return $this->hasOne(CodeSolution::getClass());
    }

    public function links(){
    	return $this->hasMany(Link::getClass());
    }
    public function warnings(){
    	return $this->hasMany(Warning::getClass());
    }
    public function files(){
    	return $this->hasMany(Files::getClass()):
    }

    public function user(){
        return $this->belongsTo(User::getClass());
    }

    public function problem(){
    	return $this->belongsTo(Problem::getClass());
    }

}
