<?php

namespace SolutionBook\Http\Controllers;

use Illuminate\Http\Request;

use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function myPerfil()
    {
        $user = auth()->user();
        $numSolutions = count($user->solutions);
        $numProblems = count($user->problems);


//        dd($user->toArray());
        return view('forEverybody.myPerfil',compact('user','numSolutions','numProblems'));
    }
}
