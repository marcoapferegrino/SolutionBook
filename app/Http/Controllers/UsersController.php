<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\Notify;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\User;
use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests\AddUserRequest;
use Illuminate\Support\Facades\Session;
use SolutionBook\Http\Requests;



class UsersController extends Controller
{
    public function myPerfil($idUser)
    {
//        $user = auth()->user();
        $user = User::find($idUser);
        $allNumLikes = 0;
        $numSolutions = count($user->solutions);
        $numProblems = count($user->problems);
        $numWarnings = count(Warning::all()->where('user_id',$user->id));
        foreach ($user->solutions as $solution ) {
            $allNumLikes += $solution->numLikes;
        }

        $ranking = ($numSolutions*env('POINTS_PER_SOLUTION'))+$allNumLikes;
        $user->ranking = $ranking;
        $user->save();

        $cSolutions = json_encode($user->mySolutionsPerLanguageAnually('c'));
        $cPlusSolutions = json_encode($user->mySolutionsPerLanguageAnually('c++'));
        $python = json_encode($user->mySolutionsPerLanguageAnually('python'));
        $java = json_encode($user->mySolutionsPerLanguageAnually('java'));

        return view('forEverybody.myPerfil',compact('user','numSolutions','numProblems',
            'numWarnings','cSolutions','cPlusSolutions','python','java'));
    }

    public function getEditPerfil()
    {
        $user = auth()->user();


        return view('auth.editPerfil',compact('user'));
    }


    public function getAddProblemSetter()
    {
        $correo=null;
        $nombre=null;
        $avatar=null;
        return view('super.registerProblemSetter',compact('correo','nombre','avatar'));
    }
    public function editPerfil(Request $request)
    {
//        dd($request->all());
        $user = auth()->user();
        $avatar = $request->avatar;
        $password = $request->password;

        if ($password!="" || $password!=null) {
            $user->password = bcrypt($password);
            $user->save();

        }

        if($avatar!=null){
            $idUser = $user->id;
            $path ='users/'.$idUser.'/';
            $pathAvatar = $path.'avatar/';
            $nameImage = $avatar->getClientOriginalName();
            $avatar->move($pathAvatar,$nameImage);
            $renameImg= 'avatar.'.$avatar->getClientOriginalExtension();
            rename($pathAvatar.$nameImage,$pathAvatar.$renameImg);
            $user->avatar = "/".$pathAvatar.$renameImg;
            $user->save();



        }
        Session::flash('message', 'Cambios guardados');
//        return redirect()->action('UsersController@myPerfil',$user->id);
        return view('auth.editPerfil',compact('user'));

    }

    public function addProblemSetter(AddUserRequest $request)
    {
        $password = bcrypt($request->password);
        $image=$request->file('avatar');
       // dd($request->type);


        $user = User::create(array('username'=>$request->username,'email'=>$request->email,'rol'=>$request->type, 'password'=>$password));
//        dd($user->id);
        if($image!=null){

        $idUser = $user->id;
        $path ='users/'.$idUser.'/';
        $pathAvatar = $path.'avatar/';

        mkdir($pathAvatar,0775, true);

        $nameImage = $image->getClientOriginalName();
       // dd($image,$pathAvatar,$nameImage);

        $image->move($pathAvatar,$nameImage);
        $renameImg= 'avatar.'.$image->getClientOriginalExtension();

        rename($pathAvatar.$nameImage,$pathAvatar.$renameImg );
        $user->avatar= $pathAvatar.$renameImg;
        $user->save();
        }

        Tools::sendEmail($user->email,$user->username,"Te han registrado como ProblemSetter","promotion");
        Session::flash('message', '¡Ya puede iniciar sesión el usuario: '.$user->username.'!');

        return redirect()->action('HomeController@indexAdmin');//return Redirect::to('/auth/login');

    }

    public function viewPromotion(){
        $idUser= auth()->user()->getAuthIdentifier();
        $solver= User::usersSolver();
        $user=User::find($idUser);
        $promovidos=$user->usersPromoted($user->rol);
        $cadena=null;
        $placeholder="Buscar por username";
        //dd($promovidos);
        return view('problem/promotion',compact('solver','promovidos','cadena','placeholder'));

    }

    public function promotion(Request $request){

        $message='';
        $idUser= auth()->user()->getAuthIdentifier();
        $idRequest=$request->id;
        $responsible=User::find($idUser);
        $usuario=User::find($idRequest);

        $tipo=$request->tipo;
        if($tipo==0)
        {
            $usuario->update(['userProblem_id'=>$idUser,'rol'=>'problem']);


            $notify=Notification::addNotifyPromote($usuario->id);
            $message=Notify::encodeMsj($usuario->id,null,null,'promoted',$notify->created_at);
            $pusher = App::make('pusher');
            $pusher->trigger( 'promotes-channel',
                'promotes-event', array($message) );
            Session::flash('message', 'El rol del Usuario: '.$usuario->username.' ha cambiado de solver a problem');
            Tools::sendEmail($usuario->email,$usuario->username,"Promoción a Problem Setter","promotion");
        }
        else
        {
            if($usuario->userProblem_id==$idUser||$responsible->rol=='super')
            {
                $usuario->update(['userProblem_id'=>null,'rol'=>'solver']);


                $notify=Notification::addNotifyDePromote($usuario->id);
                $message=Notify::encodeMsj($usuario->id,null,null,'dePromoted',$notify->created_at);
                $pusher = App::make('pusher');
                $pusher->trigger( 'promotes-channel',
                    'promotes-event', array($message) );

                Session::flash('message', 'El rol del Usuario: '.$usuario->username.' ha cambiado de problem a solver');
                Tools::sendEmail($usuario->email,$usuario->username,"De nuevo Solver","unpromotion");
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
       // $notif= Notification::all()->where('user_id','=',$id)
           //                        ->where('viewed','=',0) ->all();
        $notif=Notification::numberLikes($id);

        $aux=0;
        foreach($notif as $k=>$not){
            $aux++;


        }
            $res.='"user_id":'.$id.',';
            $res.='"likes":'.$aux.' ';
        $res.="}";
        //return  response()->json(compact('res'));
        return $res;//Json::encode($res);
        //return $res;//view('forEverybody.usersList',compact('users'));
    }
    public function findPromovidos(Request $request)
    {
        //
        $cadena=$request->buscar;
        $idUser= auth()->user()->getAuthIdentifier();
        $solver= User::usersSolver($cadena);
        $user=User::find($idUser);
        $promovidos=$user->usersPromoted($user->rol,$cadena);

        $placeholder="Buscar por username";
        //dd($solver);
        return view('problem/promotion',compact('solver','promovidos','cadena','placeholder'));
    }

}
