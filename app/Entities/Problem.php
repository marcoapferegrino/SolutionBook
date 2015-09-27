<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * Class Problem
 * @package App\Entities
 */
class Problem extends Entity {

<<<<<<< HEAD
	//
    protected $fillable = ['title', 'author', 'institution', 'description', 'numSolutions', 'limitTime', 'limitMemory', 'numWarnings', 'state', 'problemLink', 'user_id', 'judgeList_id'];
=======
	protected $table = 'problems';
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Solution
     */
    public function solutions(){
        return $this->hasMany(Solution::getClass());
    }

    /**
     * @return mixed
     */
    public function solutionsPreview()
    {
        $previewSolutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->select('users.username','solutions.id','solutions.explanation', 'solutions.numLikes','solutions.dislikes','solutions.ranking','code_solutions.limitTime','code_solutions.limitMemory','code_solutions.language')
            ->where('solutions.problem_id',$this->id)
            ->where('solutions.state','active')
            ->orderBy('solutions.ranking','desc')
            ->paginate(2);

        return $previewSolutions;
    }

}
