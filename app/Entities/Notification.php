<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Notification extends Entity {


    protected $fillable = ['title','description','user_id','viewed'];

    public function user(){
        return $this->belongsTo(User::getClass());
    }


    public static function addNotifyLike($idReceptor){


        $notify = Notification::create(
            array('title'=>'¡Tu publicación obtuvo un like!',
                'description'=>'Like',
                'user_id'=>$idReceptor));

        $notifyText = 'Like';



    }
}
