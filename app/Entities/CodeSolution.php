<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;


class CodeSolution extends Entity {

	protected $table = 'code_solutions';
	protected $fillable = array('path','language','limitTime','limitMemory','limitTimeString');

	public function solution(){
		return $this->belongsTo(Solution::getClass());
	}

}
