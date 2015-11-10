<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Psy\Util\Json;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\User;
use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests\AddUserRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Database\QueryException;

use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;


class UsersController extends Controller
{
    public function myPerfil()
    {
        $user = auth()->user();
        $allNumLikes = 0;
        $numSolutions = count($user->solutions);
        $numProblems = count($user->problems);
        $numWarnings = count(Warning::all()->where('user_id',$user->id));
        foreach ($user->solutions as $solution ) {
            $allNumLikes += $solution->numLikes;
        }

        $ranking = ($numSolutions*10)+$allNumLikes;
        $user->ranking = $ranking;
        $user->save();

        $cSolutions = json_encode($user->mySolutionsPerLanguageAnually('c'));
        $cPlusSolutions = json_encode($user->mySolutionsPerLanguageAnually('c++'));
        $python = json_encode($user->mySolutionsPerLanguageAnually('python'));
        $java = json_encode($user->mySolutionsPerLanguageAnually('java'));

//        dd($java,$cSolutions,$cPlusSolutions,$python);
        return view('forEverybody.myPerfil',compact('user','numSolutions','numProblems',
            'numWarnings','cSolutions','cPlusSolutions','python','java'));
    }

    public function getAddProblemSetter()
    {
        return view('super.registerProblemSetter');
    }

    public function addProblemSetter(AddUserRequest $request)
    {
        $password = bcrypt($request->password);
        $image=$request->file('avatar');
       // dd($request->all());

        $user = User::create(array('username'=>$request->username,'email'=>$request->email,'rol'=>'problem', 'password'=>$password));
//        dd($user->id);
        if($image!=null){

        $idUser = $user->id;
        $path ='users/'.$idUser.'/';
        $pathAvatar = $path.'avatar/';

        mkdir($pathAvatar,null, true);

        $nameImage = $image->getClientOriginalName();
       // dd($image,$pathAvatar,$nameImage);

        $image->move($pathAvatar,$nameImage);
        $renameImg= 'avatar.'.$image->getClientOriginalExtension();

        rename($pathAvatar.$nameImage,$pathAvatar.$renameImg );
        $user->avatar= $pathAvatar.$renameImg;
        $user->save();
        }


        Session::flash('message', '¡Ya puede iniciar sesión el usuario: '.$user->username.'!');

        return redirect()->action('HomeController@indexAdmin');//return Redirect::to('/auth/login');

    }

    public function viewPromotion(){
        $idUser= auth()->user()->getAuthIdentifier();
        $solver= User::usersSolver();
        $promovidos= User::find($idUser)->usersPromoted();
        $cadena=null;
        //dd($promovidos);
        return view('problem/promotion',compact('solver','promovidos','cadena'));

    }

    public function promotion(Request $request){

        $idUser= auth()->user()->getAuthIdentifier();
        $idRequest=$request->id;
        $usuario=User::find($idRequest);
        $tipo=$request->tipo;
        if($tipo==0)
        {
            $usuario->update(['userProblem_id'=>$idUser,'rol'=>'problem']);
            Session::flash('message', 'El rol del Usuario: '.$usuario->username.' ha cambiado de solver a problem');
        }
        else
        {
            if($usuario->userProblem_id==$idUser)
            {
                $usuario->update(['userProblem_id'=>null,'rol'=>'solver']);
                Session::flash('message', 'El rol del Usuario: '.$usuario->username.' ha cambiado de problem a solver');
            }
            else
                Session::flash('error', 'No tienes permitido realizar esta acción');
        }

        return redirect()->back();

    }

    public function suspendAccount(Request $request)
    {
     //   dd($request);
        $id=$request->user_id;
        $user= User::find($id);
        if($user==null){return redirect()->back();}

        $user->state='blocked';
        $user->save();

        return redirect()->back();
    }

    public function reactiveAccount(Request $request){
     //   dd(Input::all());
        $id=$request->user_id;
        $user= User::find($id);
        if($user==null){return redirect()->back();}

        $user->state='active';
        $user->save();

        return redirect()->back();


    }


    public function getUsers()
    {
        $users=User::systemUsers();

        return view('forEverybody.usersList',compact('users'));
    }
    public function findUserLikes()
    {
        $res='{';
        $user=auth()->user();
        $id=$user->id;
        $notif= Notification::all()->where('user_id','=',$id)
                                   ->where('viewed','=',0) ;
            $res.='"user_id":'.$id.',';
            $res.='"likes":'.count($notif).' ';
        $res.="}";
        //return  response()->json(compact('res'));
        return $res;//Json::encode($res);
        //return $res;//view('forEverybody.usersList',compact('users'));
    }
    public function buscarPromovidos(Request $request)
    {
        //
        $cadena=$request->buscar;
        $idUser= auth()->user()->getAuthIdentifier();
        $solver= User::usersSolver($cadena);
        $promovidos= User::find($idUser)->usersPromoted($cadena);

        //dd($solver);
        return view('problem/promotion',compact('solver','promovidos','cadena'));
    }

}
