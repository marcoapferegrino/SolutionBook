<?php

namespace App\Http\Controllers;

use App\Entities\CodeSolution;
use App\Entities\Problem;
use App\Entities\Solution;
use App\Entities\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;


class SolutionsController extends Controller
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

    public function getFormSolution()
    {

        $idProblem = 9;


        return view('solver.addSolution2',compact('idProblem'));

    }


    public function addSolution(Request $request)
    {


        //dd($request->all());
        $idProblem =$request->idProblem;
        $idUser= auth()->user()->getAuthIdentifier();

        $images = $request->file('images');
        $fileCode = $request->file('fileCode');
        $extension = "";
        $timeStatus = false;
        $path = "testing/";
        $nameFileCode = $fileCode->getClientOriginalName();

        //$fileCode->move($path, $nameFileCode );



        switch($request->language)
        {
            case 'c':
                $extension='c';
                //$compileCmd = "gcc ". $path.$nameFileCode. " -o testing/prueba";
                $compileCmd = "gcc testing/pruebaC.c -o testing/prueba 2>&1";

                exec($compileCmd,$output);

                dd($output,$extension);
                break;
            case 'c++':
                $extension = 'cpp';
                break;
            case 'java':
                $extension = 'class';
                break;
            case 'python':
                $problem = Problem::find(9);
                //dd($problem->toArray());
                $extension='py';

                $results = Tools::evaluateCodeSolution($problem, $fileCode, $extension);

                break;

        }


        if ($results['timeStatus'] && $results['memStatus']) { //si pasa la prueba de memoria y tiempo
            $codeSolution = CodeSolution::create([
                'language'      => $request->language,
                'path'          => '', //path donde esta el codigo fuente
                'limitTime'     => $results['timeExecution'],//tiempo de ejecucion del codigo
                'limitMemory'   => $results['memUsed'],

            ]);

            $solution = Solution::create([
                'explanation'       =>  $request->explanation,
                'state'             =>  'active',
                'ranking'           => 0,
                'solutionLink'      => '',//link para ver solucion cre oque no sirve
                'numWarnings'       => 0,
                'numLikes'          => 0,
                'dislikes'          => 0,
                'user_id'           => $idUser,
                'codeSolution_id'   => $codeSolution->id,
                'problem_id'        => $idProblem
            ]);



            $path ='uploads/'.$idProblem.'/'.$solution->id.'/';
            $pathImages = $path.'images/'; //path donde guardare imagenes
            $pathCode   = $path.'code/'; //path donde guardaré el código

            CodeSolution::where('id', '=', $codeSolution->id)->update(array('path' => $pathCode.$nameFileCode));

            //creamos la carpeta si no existe
            if(!is_dir($path))
            {
                mkdir($path,0,true);
                chmod($path,0755);
            }

            if ($fileCode->getClientOriginalExtension() == $extension)
            {
                $fileCode->move($pathCode,$nameFileCode);
            }


            foreach ($images as $image)
            {

                $nameImage = $image->getClientOriginalName();
                $image->move($pathImages,$nameImage);

            }
            Session::flash('message', 'Si paso todo bien');
            return redirect()->route('solution.getFormSolution');

        }//if timeStatus and memStatus
        else
        {
            return redirect()->route('solution.getFormSolution');
        }


    }





}
