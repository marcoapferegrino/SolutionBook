<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\Notify;
use SolutionBook\Entities\Solution;
use Illuminate\Http\Request;

use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;

class LikesController extends Controller
{
    public function addLike($id,Request $request)
    {

//        dd("votando por la solución:".$id);


        if(!auth()->user()->hasLiked($id))
        {
            $solution = Solution::findOrFail($id);

            $solution->numLikes+=1;
            $numDislikes = $solution->dislikes;

            if($numDislikes!=0)
            {
                $solution->dislikes-=1;
            }
            $solution->save();

            $user = auth()->user();
            $success = $user->like($solution->id);
            $idUserObjetivo=$solution->user_id;
            Notification::addNotifyLike($idUserObjetivo);///////envia notificacion
            $mensj=Notify::encodeMsj($idUserObjetivo,$id,null,'like');
            $pusher = App::make('pusher');
            $pusher->trigger( 'test-channel',
                'test-event',
                array($mensj));


            if($request->ajax()){
                return  response()->json(compact('success'));
            }
        }
        else
        {
            if($request->ajax()){
                return  response()->json(compact('fail'));
            }
            Session::flash('message', 'Ya votaste pero gracias :D');

        }

        return redirect()->back();
    }

    public function disLike($id,Request $request)
    {
        if(auth()->user()->hasLiked($id))
        {
            $solution = Solution::findOrFail($id);

            $solution->numLikes-=1;
            $solution->dislikes+=1;

            $solution->save();

            $user = auth()->user();
            $success= $user->disLike($solution->id);

            if($request->ajax()){
                return  response()->json(compact('success'));
            }
        }
        else
        {
            if($request->ajax()){
                return  response()->json(compact('fail'));
            }
            Session::flash('message', 'Ya le quitaste el like pero gracias :D');

        }

        return redirect()->back();

    }
}
