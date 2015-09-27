<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Warning extends Entity {



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

        return $this->hasMany(Link::getClass());
    }

}
