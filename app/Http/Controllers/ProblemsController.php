<?php

namespace App\Http\Controllers;

use App\Entities\JudgesList;
use Illuminate\Http\Request;
use App\Entities\Problem;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProblemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return "Hola";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function addProblem(Request $request)
    {
        //
        dd($request);
    }

    public function allProblems()
    {
        //->groupBy('problems.id')
        $result= \DB::table('problems')
            ->select('problems.id as pid ','limitTime','title','problems.description as description','numWarnings')
            ->paginate(9);

        return view('problem/allProblems',compact('result'));
    }
    public function addFormProblem()
    {
        //
        $result = \DB::table('judges_lists')->get();
        $judgeList=array("");
        foreach ($result as $r) {
            array_push($judgeList,$r->id);
        }

        return view('problem/addProblem',compact('judgeList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function deleteProblem($id)
    {
        //
        return "En desarrollo";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProblem($idProblem)
    {
        //
        $dataProblem=Problem::find($idProblem);
        //dd($dataProblem);
        $files=Problem::find($idProblem)->files;
       // $files=Problem::find($idProblem)->judgeList;
        //$files=Problem::find($idProblem)->tags;

//        $warnings=Problem::find($idProblem)->warnings;

        $links=Problem::find($idProblem)->links;

//      $solutions=Problem::find(10)->solutions;

        $problem = Problem::find($idProblem);
        $solutions = $problem->solutionsPreview();

        //dd($files);
        //dd($solutions);
        return view('problem/showProblem',compact('dataProblem','files','links','solutions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        return "En desarrollo";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateProblem($id)
    {
        //
        return "En desarrollo";
    }

    /**
     * specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function myProblems()
    {
        //
        $idUser= auth()->user()->getAuthIdentifier();
        $result= \DB::table('problems')->where('problems.user_id','=',$idUser)->paginate(9);

        return view('problem/myProblems',compact('result'));
    }
}
