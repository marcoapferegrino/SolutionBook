<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use SolutionBook\Entities\Notification;
use SolutionBook\Http\Requests;
use Illuminate\Support\Facades\App;

class NotificationsController extends Controller
{
    public function getIndex()
    {


        return view('notification');
    }

    public function postNotify(Request $request)
    {
        $notifyText = e($request->input('notify_text'));
        $pusher = App::make('pusher');
        $pusher->trigger( 'test-channel',
            'test-event',
            array($notifyText));




    }

    public function deView()
    {
        //
        $data = Input::all();
        $id =($data['id']);
        $notify = Notification::find($id);
        $notify->viewed=1;
        $notify->save();
        return $data;
    }

    public function allNotifications()
    {
        $user =  auth()->user();
        //dd($user);
        $notifications= DB::table('notifications')
             ->where('user_id','=',$user->id)
             ->orderBy('created_at','desc')->get();


        if($notifications==null){
            Session::flash('message','No tienes notificaciones');
            return view('forEverybody.notificationsList',compact('notifications'));
        }

        $noti=Notification::where('user_id','=',$user->id)->get();
        foreach($noti as $not){

            $not->viewed=1;
            $not->save();
        }

        return view('forEverybody.notificationsList',compact('notifications'));
    }


    public static function getAllNotification(){


        //return view('super.messagesPusher');
        return redirect()->back();


    }

    public static function allNotification(Request $request){

        //$message=$request->message;

        // app.blade  //<li><a href="{{url("/getAllNotification")}}"><i class="fa fa-paper-plane"></i> Enviar mensajes </a></li>
        //return view('super.messagesPusher');
        return redirect()->back();


    }
}
