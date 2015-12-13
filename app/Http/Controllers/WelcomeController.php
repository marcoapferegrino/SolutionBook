<?php namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use SolutionBook\Entities\Notice;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Style;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\User;
use SolutionBook\Http\Requests\AddUserRequest;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Session;


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
        $faker =  $faker=Faker::create();
        $verificationCode = $faker->unique()->uuid();
//        dd($verificationCode);

        $user = User::create(array(
            'username'=>$request->username,
            'email'=>$request->email,
            'confirmed'=>0,
            'confirmation_code'=> $verificationCode,
            'rol'=>'solver',
            'password'=>$password));
//        dd($user->toArray);

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
        Session::flash('message', 'Recuerda verificar tu cuenta con el email que te enviamos :D');
//        Tools::sendEmail($user->email,$user->username,"Te has registrado como Solver ","addSolver");
        Tools::sendEmail($user->email,$user->username,"Verifica tu cuenta de Solution Book","verificationMail",$verificationCode);
        return Redirect::to('/auth/login');

    }
    public function confirm($confirmation_code)
    {

        if( ! $confirmation_code)
        {
            Session::flash('message', 'Lo sentimos no hay código de verificación');
            return Redirect::to('/register');
        }

        $user = User::where('confirmation_code',$confirmation_code)->first();
//        dd($user->toArray());
        //Si no existe el usuario
        if ( ! $user)
        {
            Session::flash('message', 'Lo sentimos no existe código de verificacion asociado a este usuario o la cuenta ya está activa');
            return Redirect::to('/register');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();


        Session::flash('message','Has verificado tu cuenta con exito gracias');

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

    public function accountUnconfirmed()
    {
        return view('forEverybody.unconfirmedAccount');
    }

    public function resendEmailConfirmation(Request $request)
    {
        $email = $request->email;

        $user = User::where('email',$email)->first();
        if ($user) {
            $faker =  $faker=Faker::create();
            $verificationCode = $faker->unique()->uuid();

            $user->confirmation_code = $verificationCode;
            $user->save();

            Tools::sendEmail($user->email,$user->username,"Verifica tu cuenta de Solution Book","verificationMail",$verificationCode);
            Session::flash('message', 'Recuerda verificar tu cuenta con el email que te enviamos :D');
            return Redirect::to('/auth/login');
        } else {
            Session::flash('message', 'Por favor registrate de nuevo');
            return Redirect::to('/register');
        }

    }

}
