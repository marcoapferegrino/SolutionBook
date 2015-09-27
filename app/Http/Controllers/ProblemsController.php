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
        $result= \DB::table('problems as problems')->leftjoin('files','problems.id','=','files.problem_id')
            ->select('problems.id as pid ','files.id as fid','path','name','limitTime','title','problems.description as description','numWarnings')
            ->groupBy('problems.id')->paginate(3);
        foreach ($result as $key => $r) {
            # code...
            if (is_null($r->fid)) {
                # code...
                $r->path="default/1.png";
            }
        }
        return view('problem/problemas',compact('result'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProblem(/*$idProblem*/)
    {
        //
        $dataProblem=Problem::find(10);
        //dd($dataProblem);
        $files=Problem::find(10)->files;
       // $files=Problem::find(10)->judgeList;
        //$files=Problem::find(10)->tags;

//        $warnings=Problem::find(10)->warnings;

        $links=Problem::find(10)->links;

//      $solutions=Problem::find(10)->solutions;

        $problem = Problem::find(/*idProblem*/10);
        $solutions = $problem->solutionsPreview();

        //dd($files);
        //dd($solutions);
        return view('problem/verProblema',compact('dataProblem','files','links','solutions'));
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

        return view('problem/misProblemas',compact('result'));
    }
}
