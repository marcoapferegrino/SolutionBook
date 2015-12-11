<?php namespace SolutionBook\Http\Controllers;

use SolutionBook\Entities\Notice;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\User;

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
        if(auth()->user()->rol=="super"){

            return redirect()->action('HomeController@indexAdmin');

        }
        elseif(auth()->user()->rol=="problem"){

            return redirect()->action('HomeController@indexProblem');
        }
        elseif(auth()->user()->rol=="solver"){

            return redirect()->action('HomeController@indexSolver');
        }

        else

        $topUsers = User::topUsers();
        $notices = Notice::getNoticesWithFiles();
        $lastProblems = Problem::lastProblem();

        return view('home',compact('notices','topUsers','lastProblems'));
    }

    public function indexProblem()
    {
        $notices = Notice::getNoticesWithFiles();
        $topUsers = User::topUsers();
        $lastProblems = Problem::lastProblem();
        return view('homeProblemSetter',compact('notices','topUsers','lastProblems'));
    }

    public function indexSolver()
    {
        $notices = Notice::getNoticesWithFiles();
        $topUsers = User::topUsers();
        $lastProblems = Problem::lastProblem();
        return view('homeSolver',compact('notices','topUsers','lastProblems'));
    }

    public function indexAdmin()
    {
        $notices = Notice::getNoticesWithFiles();
        $topUsers = User::topUsers();
        $lastProblems = Problem::lastProblem();
        return view('homeAdmin' ,compact('notices','topUsers','lastProblems'));
    }


}
