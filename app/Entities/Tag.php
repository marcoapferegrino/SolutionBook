<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use SolutionBook\Entities;

class Tag extends Entity {


    protected $fillable = ['name'];


    public function problem()
    {
        return $this->belongsToMany(Problem::getClass(), 'problem_tag'); // pertenece a muchos problemas

    }


}
