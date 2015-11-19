<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use SolutionBook\Entities\Link;
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

        return view('forEveryBody.addWarning',compact('id','type'));
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
        /*Getting warnigns repeated by the same alerterUser */
        $warningRepeated = Warning::where($type==0 ? 'solution_id' : 'problem_id',$target->id)
            ->where('alerter_user',$alerterUser->id)
            ->where('reason',$reason)
            ->get();
        /*If dont exist we create the new warning else we dont.*/
        if (count($warningRepeated)==0) {
             Link::create([
                'link'=>$type==0 ? 'showSolution/' : 'showProblem/'.$target->id,
                'type'=>'Referencia',
                $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);

            User::find($target->user_id);
            $link = Link::create([
                'link'=>$request->link,
                'type'=>'Amonestación',
                $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);

            Warning::create([
                'description'   => $request->description,
                'reason'        => $reason,
                'state'         => 'process',
                'hoursToAttend' => 200, //¿?
                'link_id'       => $link->id,
                'user_id'       => $target->user_id,
                'alerter_user'  => $alerterUser->id,
                $type==0 ? 'solution_id' : 'problem_id'=>$target->id
            ]);
        }

        Session::flash('message','Hemos enviado tu amonestación la resolveremos lo más pronto posible. Gracias :D');
        return redirect()->back();


    }

    public function myWarnings()
    {
        $stri=Crypt::encrypt('hola');
        $sr=Crypt::decrypt($stri);
        //dd($stri,$sr);
        $referencia=Link::all();
        $user = auth()->user();
        if($user->rol=='super'){

            $warnings = Warning::all()->where('state','forAdmin');


        }else{
        $warnings = Warning::all()->where('user_id',$user->id)
                                  ->where('state','process');
        }

        return view('forEverybody.myWarnings',compact('warnings','referencia'));
    }

    public function ignoreWarning(Request $request)
    {
        $id=$request->warning_id;
        $warning= Warning::findOrFail($id);
        $warning->state="forAdmin";
        $warning->save();

        return redirect()->route('warning.myWarnings');
    }
    public function deleteWarning(Request $request)
    {
        $id=$request->warning_id;
        try{
            $warning= Warning::findOrFail($id);
            $warning->delete();

            Session::flash('message','Se borró la amonestación :D');
        }
        catch(Exception $e){


        }



        return redirect()->route('warning.myWarnings');
    }
}
