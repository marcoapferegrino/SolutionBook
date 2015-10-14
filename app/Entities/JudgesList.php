<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

class JudgesList extends Entity {

    protected $fillable = ['name','addressWeb','facebook','twitter','image'];

	 public function user(){
        return $this->belongsTo(Problem::getClass());
    }


}
