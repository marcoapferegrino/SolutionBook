<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use SolutionBook\Entities;

class Warning extends Entity
{
    protected $fillable = array('description','reason','hoursToAttend','state','alerter_user','type','problem_id','user_id','solution_id','link_id');


    public function warnings()
    {

        return $this->belongsTo(User::getClass());
    }

    public function problems()
    {

        return $this->belongsTo(Problem::getClass());

    }

    public function solutions()
    {

        return $this->belongsTo(Solution::getClass());
    }

    public function links()
    {
        return $this->hasMany(Link::getClass(),'id','link_id');
    }
}