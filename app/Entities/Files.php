<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Files extends Entity {

	//
	public function notice(){
    	return $this->belongsTo(Notice::getClass());
    }
    public function solution(){
    	return $this->belongsTo(Solution::getClass());
    }
    public function problem(){
    	return $this->belongsTo(Problem::getClass());
    }
}
