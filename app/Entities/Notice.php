<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Notice extends Entity {



    protected $fillable = ['title','description','finishDate','user_id'];

    public function user(){
        return $this->belongsTo(User::getClass());
    }

    public static function getNoticesWithFiles(){

        $files = DB::table('files')
            ->join('notices','notices.id','=','files.notice_id')
            ->select('files.path','notices.id','notices.title','notices.description','notices.finishDate')
            ->get();

        return $files;
    }



}
