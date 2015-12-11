<?php namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use SolutionBook\Entities\Notice;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Style;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\User;
use SolutionBook\Http\Requests\AddUserRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;


class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

    public function indexGuest()
    {

        if(auth()->user()){

        return redirect()->action('HomeController@index');
        }
        $topUsers = User::topUsers();
        $notices = Notice::getNoticesWithFiles();
        $lastProblems = Problem::lastProblem();
        return view('home',compact('notices','topUsers','lastProblems'));
    }

    public function getRegister()
    {
        User::searchUsername();
        $correo=null;
        $nombre=null;
        $avatar=null;
        return view('register',compact('correo','nombre','avatar'));
    }

    public function findUsername()
    {
        //print_r('ff');
        $data = Input::all();
        $cadena =strtoupper($data['username']);
        $nicks= User::searchUsername();

        foreach($nicks as $nick){

            if(strtoupper($nick->username)==$cadena){


                return '{ "res" :"no" }';
            }

        }
        return '{ "res" :"yes" }';

    }
    public function configurationSolutionBook()
    {
        $styles=Style::all();

        return view('super.configuration',compact('styles'));
    }
    public function activateCss(Request $request)
    {
        //dd($request->all());
        $styles=Style::all();

        $id=$request->style_id;
        foreach($styles as $style){
            if($style->id==$id){
                $style->state='Activo';
                $style->save();
            }else{

                $style->state='No activo';
                $style->save();

            }



        }

        return redirect()->action('WelcomeController@configurationSolutionBook');
    }

    public function addRegister(AddUserRequest $request)
    {
        $password = bcrypt($request->password);

       // $file = Input::file('avatar');
        $image=$request->file('avatar');


        $user = User::create(array('username'=>$request->username,'email'=>$request->email,'rol'=>'solver', 'password'=>$password));
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

        Session::flash('message', 'Tu registro fue exitoso '.$user->username.'');//MSG01
        Tools::sendEmail($user->email,$user->username,"Te has registrado como Solver","addSolver");
        return Redirect::to('/auth/login');

    }

    public function blockedByAdmin()
    {
        $user=auth()->user();
        if($user!=null){
           return redirect()->action('HomeController@index');
        }

        return view('forEverybody.blockedByAdmin');
    }

}
