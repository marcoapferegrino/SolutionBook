<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

class Files extends Entity {

	protected $fillable = ['name','path','description','type','solution_id','problem_id','notice_id'];

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
