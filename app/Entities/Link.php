<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

class Link extends Entity {
    protected $fillable = ['link','type','solution_id','problem_id'];
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
