<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

class JudgesList extends Entity {


	 public function user(){
        return $this->belongsTo(Problem::getClass());
    }


}
