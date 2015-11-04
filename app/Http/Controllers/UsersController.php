<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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

        $numSolutions = count($user->solutions);
        $numProblems = count($user->problems);
        $numWarnings = count(Warning::all()->where('user_id',$user->id));
//        dd($numWarnings);
        return view('forEverybody.myPerfil',compact('user','numSolutions','numProblems','numWarnings'));
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

    public function suspendAccount(Request $request)
    {
        $id=$request->user_id;
        $user= User::find($id);
        if($user==null){return redirect()->back();}

        $user->state='blocked';
        $user->save();

        return redirect()->route('warning.myWarnings');
    }

}
