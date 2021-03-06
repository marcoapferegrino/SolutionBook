<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Solution extends Entity {

    protected $fillable = array('explanation','state','solutionLink','numWarnings','numLikes','dislikes','problem_id','user_id','codeSolution_id');
    protected $table = 'solutions';
    /**
     * Esta es la relacion de muchos a muchos de los Likes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::getClass());
    }

    public function codeSolution()
    {
    	return $this->hasOne(CodeSolution::getClass(),'id');
    }

    public function links(){
    	return $this->hasMany(Link::getClass());
    }
    public function warnings(){
    	return $this->hasMany(Warning::getClass());
    }
    public function files(){
    	return $this->hasMany(Files::getClass());
    }

    public function user(){
        return $this->belongsTo(User::getClass());
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Problem
     */
    public function problem(){
    	return $this->belongsTo(Problem::getClass());
    }

    /**
     * Regresa la solución para mostrarla con sus detalles
     * @return mixed
     */
    public function solutionComplete()
    {
        $previewSolutions = DB::table('solutions')->where('solutions.id',$this->id)
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->select('users.id as userId','users.username','users.email','users.rol','users.avatar','users.institution','solutions.id','problem_id',
                'solutions.explanation', 'solutions.numLikes','solutions.dislikes',
                'code_solutions.limitTimeString','code_solutions.limitMemory','code_solutions.language',
                'code_solutions.path')
            ->first();

        return $previewSolutions;
    }


}
