<?php

namespace SolutionBook\Http\Controllers;

use SolutionBook\Entities\CodeSolution;
use SolutionBook\Entities\Files;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Solution;
use SolutionBook\Entities\EvaluateCodeTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SolutionBook\Http\Requests\AddSolutionRequest;

use SolutionBook\Http\Requests;


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

        $idProblem = 10;


        return view('solver.addSolution',compact('idProblem'));

    }


    public function addSolution(AddSolutionRequest $request)
    {
//        dd($request->all());
        $idProblem      =$request->idProblem;
        $idUser         = auth()->user()->getAuthIdentifier();

        $images         = $request->file('images');
        $fileCode       = $request->file('fileCode');

        $nameFileCode   = $fileCode->getClientOriginalName();
        $audioFile      = $request->file('audioFile');
        $nameAudioFile  = $audioFile->getClientOriginalName();
        $language       = $request->optionsLanguages;
        $problem        = Problem::find($idProblem);

        $extension      = EvaluateCodeTool::getExtentionByLanguage($language);
        $results        = EvaluateCodeTool::evaluateCodeSolution($problem, $fileCode, $extension);

        if ($results['timeStatus'] && $results['memStatus']) { //si pasa la prueba de memoria y tiempo
            $codeSolution = CodeSolution::create([
                'language'      => $language,
                'path'          => '', //path donde esta el codigo fuente
                'limitTime'     => $results['timeExecution'],//tiempo de ejecucion del codigo
                'limitMemory'   => $results['memUsed'], //memoria usada por el codigo

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

            $path ='uploads/'.$idProblem.'/solutions/'.$solution->id.'/';
            $pathImages = $path.'images/'; //path donde guardare imagenes
            $pathCode   = $path.'code/'; //path donde guardaré el código
            $pathAudioFile   = $path.'audio/'; //path donde guardaré audio

            CodeSolution::where('id', '=', $codeSolution->id)->update(array('path' => $pathCode.$nameFileCode));

            //creamos la carpeta si no existe
            if(!is_dir($path))
            {
                mkdir($path,0,true);
                chmod($path,0755);
            }
            //guardando Código
            if ($fileCode->getClientOriginalExtension() == $extension)
            {
                $fileCode->move($pathCode,$nameFileCode);
            }
            //guardando audio
            if ($audioFile->getClientOriginalExtension() == "mp3")
            {
                $fileAudio = Files::create([
                    'name' => $nameAudioFile,
                    'path' => $pathAudioFile.$nameAudioFile,
                    'type'=>'notaVoz',
                    'solution_id'=>$solution->id,
                ]);

                $fileAudio->save();
                $audioFile->move($pathAudioFile,$nameAudioFile);
            }
            //guardando imagenes
            foreach ($images as $image)
            {
                $nameImage = $image->getClientOriginalName();
                $fileImage = Files::create([
                    'name' => $nameImage,
                    'path' => $pathImages.$nameImage,
                    'type'=>'imagenApoyo',
                    'solution_id'=>$solution->id,
                ]);
                $fileImage->save();
                $image->move($pathImages,$nameImage);
            }

            Link::create([
                'link' => $request->youtube,
                'type' => 'youTube',
                'solution_id'=>$solution->id
            ]);
            Link::create([
                'link' => $request->repositorio,
                'type' => 'Github',
                'solution_id'=>$solution->id
            ]);
            Link::create([
                'link' => $request->web,
                'type' => 'Facebook',
                'solution_id'=>$solution->id
            ]);



            Session::flash('message', 'Si paso todo bien');
            return redirect()->route('solution.getFormSolution');

        }//end if de timeStatus and memStatus
        else
        {
            return redirect()->route('solution.getFormSolution');
        }


    }

    public function partialSolutions()
    {
        $idProblem = 10;
        $problem = Problem::find($idProblem);
        $solutions = $problem->solutionsPreview();
        return view('solver.previewsSolution',compact('solutions'));

    }

    public function showSolution($idSolution)
    {
        //dd($id);
        $solution = Solution::findOrFail($idSolution);
//        dd($solution->toArray());
        $images = Files::where('solution_id',$solution->id)->where('type','imagenApoyo')->get();
        $audio = Files::where('solution_id',$solution->id)->where('type','notaVoz')->get();
        $solutionComplete = $solution->solutionComplete();
//        dd($solutionComplete);
        $links = Link::all()->where('solution_id',intval($idSolution));
//   dd($idSolution,$links->toArray());
        $code = file_get_contents($solutionComplete->path);

        $code=htmlspecialchars("\n".$code);
        //dd($files->toArray());
        return view('solver.solution',compact('solutionComplete','images','code','audio','links','solution'));
    }



}
