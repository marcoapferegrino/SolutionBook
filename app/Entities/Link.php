<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Link extends Entity {

	//
	public function warning(){
    	return $this->belongsTo(Warning::getClass());
    }
    public function solution(){
    	return $this->belongsTo(Solution::getClass());
    }
    public function problem(){
    	return $this->belongsTo(Problem::getClass());
    }
}
