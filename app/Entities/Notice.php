<?php namespace SolutionBook\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Notice extends Entity {



    protected $fillable = ['title','description','finishDate','user_id'];

    public function user(){
        return $this->belongsTo(User::getClass());
    }

    public static function getNoticesWithFiles(){

        $today= Carbon::now()->toDateString();
        $files = DB::table('files')
            ->join('notices','notices.id','=','files.notice_id')
            ->select('files.path','notices.id as id','notices.title','notices.description','notices.finishDate')
          // ->select([DB::raw('DISTINCT(notices.id)'),'files.path','notices.id','notices.title','notices.description','notices.finishDate'])
            ->where('notices.finishDate','>=',$today)
            ->orderBy('notices.finishDate','desc')
            ->get();

        //dd($files);

        $newFiles = array();
        foreach($files as $k=>$file){
            if($k!=0){

            if($file->id==$files[$k-1]->id){

            }
                else{

                    array_push($newFiles,$file);

                }
            }
            else{
                array_push($newFiles,$file);

            }

        }

        //dd($newFiles);

        return $newFiles;
    }

    public static function getOneNoticeWithFiles($id){

        $notice = DB::table('files')
            ->join('notices','notices.id','=','files.notice_id')
            ->select('files.path','files.name','files.type','notices.id','notices.title','notices.description','notices.finishDate')
            ->where('notices.id',$id)
            ->get();


        return $notice;
    }

    public static function getGallery(){

        $notice = DB::table('files')
            ->join('notices','notices.id','=','files.notice_id')
            ->select('files.id','files.path','files.name','files.type','notices.id as notice_id')
            ->where('files.type','imagenGallery')
            ->get();

       // dd($notice);
        return $notice;
    }



}
