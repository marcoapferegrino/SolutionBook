<?php namespace SolutionBook\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Notification extends Entity {



    protected $fillable = ['title','description','user_id','viewed'];
    public $hoy;
    public function user(){
        return $this->belongsTo(User::getClass());
    }


    public static function addNotifyLike($idReceptor,$idSolution){


        $notify = Notification::create(
            array('title'=>'¡Tu publicación obtuvo un like!',
                'description'=>'Like',
                'url'=> '/showSolution/'.$idSolution,
                'user_id'=>$idReceptor));

        $notify->url='/showSolution/'.$idSolution;
        $notify->created_at=Carbon::now();
        $notify->save();

        return $notify;
    }

    public static function addNotifyWarning($idReceptor,$idSolution,$idProblem){

        $id=null;
        $url='/myWarnings';
        if($idSolution==null){

            $id=$idProblem;
            //$url='/showProblem/';

        }else{
            $id=$idSolution;
            //$url='/showSolution/';


        }


        $notify = Notification::create(
            array('title'=>'Tu publicación tiene una amonestación.',
                'description'=>'Warning',
                //  'url'=> $url.$id,
                'url'=> $url,
                'user_id'=>$idReceptor));

        $notify->url=$url;

        $notify->created_at=Carbon::now();
        $notify->save();

        return $notify;
    }
    public static function addNotifyPromote($idReceptor){

        $id=null;
        $url='/miPerfil';

        $notify = Notification::create(
            array('title'=>'Ahora eres Problem Setter. ¡Felicidades!',
                'description'=>'Promote',
                //  'url'=> $url.$id,
                'url'=> $url,
                'user_id'=>$idReceptor));

        $notify->url=$url;

        $notify->created_at=Carbon::now();
        $notify->save();

        return $notify;
    }
    public static function addNotifyDePromote($idReceptor){

        $id=null;
        $url='/miPerfil';

        $notify = Notification::create(
            array('title'=>'Tu cuenta cambio a tipo Solver.',
                'description'=>'DePromote',
                //  'url'=> $url.$id,
                'url'=> $url,
                'user_id'=>$idReceptor));

        $notify->url=$url;

        $notify->created_at=Carbon::now();
        $notify->save();

        return $notify;
    }

    public static function numberLikes($id){


        $notif = DB::table('notifications')
                    ->where('user_id','=',$id)
                    ->where('viewed','=',0)->get();

        return $notif;

    }
}
