<?php

namespace SolutionBook\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\Notify;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Solution;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\User;
use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests;

class WarningsController extends Controller
{
    public function getAddWarning($id,$type)
    {
        return view('forEverybody.addWarning',compact('id','type'));
    }

    public function addWarning(Request $request)
    {

        $alerterUser = auth()->user();
        $type   = $request->type;
        $id     = $request->id;
        $reason = $request->reason;

        if ($type == 0) {//solution
            $target = Solution::find($id);

        } elseif ($type==1) {//problem
            $target = Problem::find($id);

        }
        else{
            Session::flash('error','Parece que no es un formato aceptable');
            return redirect()->route('warning.getAddWarning');
        }
        $user=User::find($target->user_id);
        /*Getting warnigns repeated by the same alerterUser */
        $warningRepeated = Warning::where($type==0 ? 'solution_id' : 'problem_id',$target->id)
            ->where('alerter_user',$alerterUser->id)
            ->where('reason',$reason)
            ->get();
        /*If dont exist we create the new warning else we dont.*/
        if (count($warningRepeated)==0) {

            $linkAux=$type==0 ? 'showSolution/' : 'showProblem/';
             $link=Link::create([
                'link'=>$linkAux.$target->id,
                'type'=>'Referencia',
                $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);

            User::find($target->user_id);
            if ($request->link!="" || $request->link!=null) {
                $link = Link::create([
                    'link'=>$request->link,
                    'type'=>'Amonestación',
                    $type==0 ? 'solution_id' : 'problem_id'=>$target->id,
                ]);
            }


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
        $target->state='suspended';
        $target->save();
        $warning = Warning::create([
            'description'   => $request->description,
            'reason'        => $reason,
            'state'         => 'process',
            'hoursToAttend' => 200, //¿?
            'link_id'       => $link->id,
            'user_id'       => $target->user_id,
            'alerter_user'  => $alerterUser->id,
            'created_at'    => Carbon::now(),
            $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);

//            $warning->created_at=Carbon::now();
//            $warning->save();
        }//end if is not repeated

//        Tools::sendEmail($user->email,$user->username,"Te han amonestado","addWarning");
        Session::flash('message','Hemos enviado tu amonestación la resolveremos lo más pronto posible. Gracias :D');
        return redirect()->back();


    }

    public function myWarnings()
    {
        $limit= Carbon::now()->subDays(14)->toDateString();
        $warnings=Warning::where('warnings.created_at','<',$limit)->where('warnings.state','=','process')->get();

        foreach($warnings as $warning){
            $warning->state='forAdmin';
            $warning->save();

        }
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
        if (count($warnings)==0) {
            Session::flash('message','¡Genial no tienes amonestaciones! :D');
        }
        return view('forEverybody.myWarnings',compact('warnings','referencia','alerter'));
    }

    public function ignoreWarning(Request $request)
    {
        $id=$request->warning_id;
        $warning= Warning::findOrFail($id);
        $warning->state="forAdmin";
        $warning->save();

        if($warning->solution_id==null){//es un problema
        $problem=Problem::find($warning->problem_id);
        $problem->state="active";
        $problem->save();

        }
        else{//es una solucion

        $solution=Solution::find($warning->solution_id);
        $solution->state="active";
        $solution->save();


        }
        Session::flash('message','Amonestación ignorada');//msg24
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

        if($warning->solution_id==null){//es un problema
            $problem=Problem::find($warning->problem_id);
            $problem->state="blocked";
            $problem->save();


        }
        else{//es una solucion

            $solution=Solution::find($warning->solution_id);
            $solution->state="blocked";
            $solution->save();


        }
        $user->save();

        Session::flash('message','Acción concluida exisamente :D');
        return redirect()->route('warning.myWarnings');
    }
    public function deleteWarning(Request $request)
    {
        $id=$request->warning_id;
        $warning=Warning::find($id);
        try{
            $warning= Warning::findOrFail($id);
            $link=Link::find($warning->link_id);

            if($warning->solution_id==null){

                $linkSec=Link::all()->where('links.problem_id','=',$warning->problem_id);
                $linkSec->delete();

            }
            else{
                $linkSec=Link::all()->where('links.solution_id','=',$warning->solution_id);
                $linkSec->delete();


            }
            $link->delete();
            $warning->delete();

            Session::flash('message','Se borró la amonestación');
        }
        catch(Exception $e){


        }



        return redirect()->route('warning.myWarnings');
    }
}
