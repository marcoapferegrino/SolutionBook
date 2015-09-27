<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;

class Tag extends Entity {


    protected $fillable = ['name'];


    public function problem()
    {
        return $this->belongsToMany(Problem::getClass(), 'problem_tag'); // pertenece a muchos problemas

    }


}
