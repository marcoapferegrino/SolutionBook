<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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



    public static function getAlerters(){

        $alerters = DB::table('users')
            ->select('id','username')
            ->get();


        return $alerters;
    }
    /**
     * @param $field
     * @param $targetId
     */
    public static function expireWarnings($field,$targetId){
        $warnings = Warning::where($field,$targetId)->where('state','process')->get();
//        dd($warnings->toArray());
        if (count($warnings)>0) {
            foreach ($warnings as $war) {
                $war->state = 'expired';
                $war->save();
            }

        }

    }
}