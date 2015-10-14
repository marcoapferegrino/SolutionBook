<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;


class Notice extends Entity {



    protected $fillable = ['title','description','finishDate','user_id'];

    public function user(){
        return $this->belongsTo(User::getClass());
    }



}
