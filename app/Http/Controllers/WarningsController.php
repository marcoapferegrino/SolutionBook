<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
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
        $numWarnings=$user->numWarnings+=1;
        $user->update(['numWarnings'=>$numWarnings]);
        $user->save();

        Session::flash('message','Hemos enviado tu amonestación la resolveremos lo más pronto posible. Gracias :D');
        return redirect()->back();


    }

    public function myWarnings()
    {
        $user = auth()->user();
        $warnings = Warning::all()->where('user_id',$user->id);

        return view('forEverybody.myWarnings',compact('warnings'));
    }
}
