<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;
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
}
