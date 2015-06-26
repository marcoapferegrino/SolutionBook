<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;
class Problem extends Entity {

	//

    public function user(){
        return $this->belongsTo(User::getClass());
    }


    public function judgeList()
    {
        return $this->hasOne(JudgesList::getClass());
    }

    public function tags()
    {
        return $this->hasMany(Tag::getClass());
    }

    public function warnings(){
        return $this->hasMany(Warning::getClass());
    }

    public function links(){
        return $this->hasMany(Link::getClass());
    }

    public function files(){
        return $this->hasMany(Files::getClass());
    }

    public function solutions(){
        return $this->hasMany(Solution::getClass());
    }
}
