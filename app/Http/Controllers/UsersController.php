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

}
