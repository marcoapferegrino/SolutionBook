<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;

class CodeSolution extends Entity {

	//
	public function solution(){
		return $this->belongsTo(Solution::getClass());
	}

}
