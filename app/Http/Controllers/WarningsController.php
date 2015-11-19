<?php

namespace SolutionBook\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\Notify;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Solution;
use SolutionBook\Entities\User;
use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;

class WarningsController extends Controller
{
    public function getAddWarning($id,$type)
    {
        return view('forEverybody.addWarning',compact('id','type'));
    }

    public function addWarning(Request $request)
    {

        $message='';  //mensaje para enviar por pusher
        $alerterUser = auth()->user();
        $type   = $request->type;
        $id     = $request->id;
        if ($type == 0) {//solution
            $target = Solution::find($id);
            $linksol = Link::create([
                'link'=>'showSolution/'.$id,
                'type'=>'Referencia',
                $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);


//            dd($linksol);

        } elseif ($type==1) {//problem
            $target = Problem::find($id);
            $linksol = Link::create([
                'link'=>'showProblem/'.$id,
                'type'=>'Referencia',
                $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);
        }
        else{
            Session::flash('error','Parece que no es un formato aceptable');
            return redirect()->route('warning.getAddWarning');
        }

        $user=User::find($target->user_id);

        if($type==0){//solucion  pusher

            $notify=Notification::addNotifyWarning($user->id,$target->id,null);
            $message=Notify::encodeMsj($user->id,$id,null,'warning',$notify->created_at);
            $pusher = App::make('pusher');
            $pusher->trigger( 'warnings-channel',
                'warnings-event', array($message) );

        }elseif($type==1){//problema pusher

            $notify=Notification::addNotifyWarning($user->id,null,$target->id);
            $message=Notify::encodeMsj($user->id,null,$id,'warning',$notify->created_at);
            $pusher = App::make('pusher');
            $pusher->trigger( 'warnings-channel',
                'warnings-event', array($message) );


        }

        $link = Link::create([
            'link'=>$request->link,
            'type'=>'Amonestación',
            $type==0 ? 'solution_id' : 'problem_id'=>$target->id
        ]);

        $warning = Warning::create([
            'description'   => $request->description,
            'reason'        => $request->optionsLanguages,
            'state'         => 'process',
            'hoursToAttend' => 200, //¿?
            'link_id'       => $link->id,
            'user_id'       => $target->user_id,
            'alerter_user'  => $alerterUser->id,
            $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);
        $warning->created_at=Carbon::now();
        $warning->save();
        /*$numWarnings=$user->numWarnings+=1;  //incrementa en uno
        $user->update(['numWarnings'=>$numWarnings]);
        $user->save();*/


        Session::flash('message','Hemos enviado tu amonestación la resolveremos lo más pronto posible. Gracias :D');
        return redirect()->back();


    }

    public function myWarnings()
    {



        $limit= Carbon::now()->subDays(14)->toDateString();
        $warnings=Warning::where('warnings.created_at','<',$limit)->where('warnings.state','=','process')->get();
       // dd($warnings);
        //$warnings=Warning::all()
        //       ->where('warnings.created_at','>',$limit);

        foreach($warnings as $warning){
            $warning->state='forAdmin';
            $warning->save();

        }

        ///


        $referencia=Link::all();
        $user = auth()->user();
        $alerter=Warning::getAlerters();
        if($user->rol=='super'){

            $warnings = Warning::all()->where('state','forAdmin');


        }else {
            $warnings = Warning::where('user_id' ,$user->id)
                                   // ->where('state','');
                                    ->where('state','!=','forAdmin')->get();

        }

        return view('forEverybody.myWarnings',compact('warnings','referencia','alerter'));
    }

    public function ignoreWarning(Request $request)
    {
        $id=$request->warning_id;
        $warning= Warning::findOrFail($id);
        $warning->state="forAdmin";
        $warning->save();

        return redirect()->route('warning.myWarnings');
    }

    public function validateWarning(Request $request)
    {
        $id=$request->user_id;
        $user=User::find($id);
        $idWar=$request->warning_id;
        $warning=Warning::find($idWar);
        $numWarnings=$user->numWarnings+=1;  //incrementa en uno
        $user->update(['numWarnings'=>$numWarnings]);
        $warning->update(['state'=>'expired']);
        $user->save();

        Session::flash('message','Acción concluida exisamente :D');
        return redirect()->route('warning.myWarnings');
    }
    public function deleteWarning(Request $request)
    {
        $id=$request->warning_id;
        try{
            $warning= Warning::findOrFail($id);
            $warning->delete();

            Session::flash('message','Se borró la amonestación');
        }
        catch(Exception $e){


        }



        return redirect()->route('warning.myWarnings');
    }
}
