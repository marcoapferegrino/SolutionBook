<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use SolutionBook\Entities\Notice;
use SolutionBook\Http\Requests;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use SolutionBook\Http\Requests\AddNoticeRequest;

use SolutionBook\Http\Requests\UpdateNoticeRequest;
use SolutionBook\Http\Controllers\Controller;


class NoticesController extends Controller
{
    //


    public function getAddNotice()
    {

        return view('super.addNotice');
    }

    public function getNotices()
    {
        $notices = Notice::all();

        return view('super.notices',compact('notices'));
    }


    public function addNotice(AddNoticeRequest $request)
    {

        $notice = Notice::create(array('title'=>$request->title,'description'=>$request->description, 'finishDate'=>$request->finishDate,'user_id'=>auth()->user()->id));

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

        //dd($request->all());
        $notice = Notice::find($request->id);

        $notice->title      = $request->title;
        $notice->description= $request->description;
        $notice->finishDate = $request->finishDate;
        $notice->save();

        Session::flash('message','Noticia ha sido actualizada');
        return redirect()->action('NoticesController@getNotices');
    }


}
