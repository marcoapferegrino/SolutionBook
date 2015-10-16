<?php namespace SolutionBook\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
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
		$this->middleware('guest');
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


    public function getRegister()
    {
        return view('register');
    }

    public function addRegister(AddUserRequest $request)
    {
        $password = bcrypt($request->password);
        $user = User::create(array('username'=>$request->username,'email'=>$request->email,'rol'=>'solver', 'password'=>$password));

        Session::flash('message', '¡Ya puedes iniciar sesión '.$user->username.'!');

        return Redirect::to('/auth/login');

    }

}
