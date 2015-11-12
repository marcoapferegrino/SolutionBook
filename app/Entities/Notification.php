<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Notification extends Entity {


    protected $fillable = ['title','description','user_id','viewed'];

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
