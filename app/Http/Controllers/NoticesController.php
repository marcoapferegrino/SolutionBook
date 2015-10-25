<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use SolutionBook\Entities\Files;
use SolutionBook\Entities\Notice;
use SolutionBook\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use SolutionBook\Http\Requests\AddNoticeRequest;

use SolutionBook\Http\Requests\UpdateNoticeRequest;
use SolutionBook\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


class NoticesController extends Controller
{
    //


    public function getAddNotice()
    {

        return view('super.addNotice');
    }

    public function getNotices()
    {
        $notices = Notice::getNoticesWithFiles();
        //$files=Notice::getFiles();

        return view('super.notices',compact('notices'));
    }


    public function addNotice(AddNoticeRequest $request)
    {


        $notice = Notice::create(
                        array('title'=>$request->title,
                              'description'=>$request->description,
                              'finishDate'=>$request->finishDate,
                              'user_id'=>auth()->user()->id));

        $fileImg      = $request->file('file');

        if($fileImg==null){

            $fileImg      = 'default.jpg';

        }

        $idUser = auth()->user()->id;
        $path ='users/'.$idUser.'/';
        $pathFile = $path.'notices/'.$notice->id.'/';

        mkdir($pathFile,null, true);
        if($fileImg!='default.jpg'){
        $nameFile = $fileImg->getClientOriginalName();
        }
        else{
        $nameFile =$fileImg;
        }

        $file = Files::create([
        'name' => $nameFile,
        'path' => $pathFile.$nameFile,
        'type' =>'imagenApoyo',
        'notice_id'=>$notice->id,

         ]);

        $file->save();
        if($nameFile=='default.jpg'){

            copy($nameFile,$pathFile.$nameFile);
        }
        else{
        $fileImg->move($pathFile,$nameFile);
        }

        return redirect()->action('HomeController@indexAdmin');

    }

    public function deleteNotice($id)
    {
        $notice = Notice::findOrFail($id);
        try
        {
            $notice->delete();
            Session::flash('message', 'Se ha eliminado la noticia');
        }
        catch(QueryException $e)
        {

            Session::flash('message', 'NO se elimino la noticia');

        }

        return redirect()->action('NoticesController@getNotices');
    }


    public function updateNotice(UpdateNoticeRequest $request)
    {

        $fileImg      = $request->file('file');
        $notice = Notice::find($request->id);

        $notice->title      = $request->title;
        $notice->description= $request->description;
        $notice->finishDate = $request->finishDate;
        $notice->save();
        if($fileImg!=null)
        {
            $file=Files::where('notice_id',$notice->id)->get()->all() ;
            if($file!=null){

                $realFile=Files::find($file[0]['id']);

                if($realFile->path!=null){
                    unlink($realFile->path);
                }
                $nameFile = $fileImg->getClientOriginalName();
                $idUser = auth()->user()->id;
                $path ='users/'.$idUser.'/';
                $pathFile = $path.'notices/'.$notice->id.'/';
                $realFile->name=$nameFile;
                $realFile->path=$pathFile.$nameFile;

                $fileImg->move($pathFile,$nameFile);
                $realFile->save();


            }
            else{


                $nameFile = $fileImg->getClientOriginalName();
                $idUser = auth()->user()->id;
                $path ='users/'.$idUser.'/';
                $pathFile = $path.'notices/'.$notice->id.'/';

                $file = Files::create([
                    'name' => $nameFile,
                    'path' => $pathFile.$nameFile,
                    'type' =>'imagenApoyo',
                    'notice_id'=>$notice->id,

                ]);

                $file->save();

                $fileImg->move($pathFile,$nameFile);






            }




        }

        Session::flash('message','Noticia ha sido actualizada');
        return redirect()->action('NoticesController@getNotices');
    }


}
