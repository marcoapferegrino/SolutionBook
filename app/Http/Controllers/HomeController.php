<?php namespace SolutionBook\Http\Controllers;

use SolutionBook\Entities\Notice;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
    public function index()
    {
        return view('home');
    }

    public function indexProblem()
    {
        return view('homeProblemSetter');
    }

    public function indexSolver()
    {
        return view('homeSolver');
    }

    public function indexAdmin()
    {

        $notices = Notice::getNoticesWithFiles();

        return view('homeAdmin' ,compact('notices'));
    }


}
