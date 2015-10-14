<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use SolutionBook\Entities\Notice;
use SolutionBook\Http\Requests;
use SolutionBook\Http\Requests\AddNoticeRequest;
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


}
