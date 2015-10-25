<?php

namespace SolutionBook\Http\Controllers;

use Exception;
use SolutionBook\Entities\CodeSolution;
use SolutionBook\Entities\Files;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Solution;
use SolutionBook\Entities\EvaluateCodeTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SolutionBook\Entities\Tools;
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

    public function getFormSolution($idProblem)
    {

        return view('solver.addSolution',compact('idProblem'));

    }


    public function addSolution(AddSolutionRequest $request)
    {
//        dd($request->all());
        $idProblem      =$request->idProblem;
        $idUser         = auth()->user()->getAuthIdentifier();

        $images = $request->file('images');
        $fileCode       = $request->file('fileCode');
        $audioFile      = $request->file('audioFile');
        $language       = $request->optionsLanguages;

        $problem        = Problem::find($idProblem);

        if ($audioFile!=null) {
            $nameAudioFile  = $audioFile->getClientOriginalName();
        }
        $nameFileCode   = $fileCode->getClientOriginalName();

        $extension      = EvaluateCodeTool::getExtentionByLanguage($language);
        $results        = EvaluateCodeTool::evaluateCodeSolution($problem, $fileCode, $extension);


//        dd($results);
        if ($results['compare'] && $results['timeStatus'] && $results['memStatus']) { //si pasa la prueba de memoria y tiempo
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

                mkdir($path,0755,true);
                mkdir($pathCode,0755,true);
//                chmod($path,0777);

            //guardando Código
            if ($fileCode->getClientOriginalExtension() == $extension)
            {
                try {
                    $pathTemporal = public_path()."/".$results["pathCode"];
                    $pathNow = public_path()."/".$pathCode.$nameFileCode;

                    if (!rename($pathTemporal,$pathNow)) {
                        Session::flash('error', 'No se pudo mover el archivo del código');
                    }
                } catch (Exception $e) {
                    Session::flash('error', 'No se pudo mover el archivo del código');
                }
            }
            //guardando audio
            if($audioFile!=null)
            {
                if ($audioFile->getClientOriginalExtension() == "mp3")
                {
                    try {
                        $fileAudio = Files::create([
                            'name' => $nameAudioFile,
                            'path' => $pathAudioFile.$nameAudioFile,
                            'type'=>'notaVoz',
                            'solution_id'=>$solution->id,
                        ]);

                        $fileAudio->save();
                        $audioFile->move($pathAudioFile,$nameAudioFile);
                    } catch (Exception $e) {
                        Session::flash('error', 'No se pudo mover el archivo del audio');
                    }
                }
            }
            //guardando imagenes
            if ($images[0]!=null) {
                foreach ($images as $image)
                {
                    try {
                        $nameImage = $image->getClientOriginalName();
                        $fileImage = Files::create([
                            'name' => $nameImage,
                            'path' => $pathImages.$nameImage,
                            'type'=>'imagenApoyo',
                            'solution_id'=>$solution->id,
                        ]);
                        $fileImage->save();
                    } catch (Exception $e) {
                        Session::flash('error', 'no se pudo gruardar la imagen:'.$nameImage);
                    }
                    try {
                        $image->move($pathImages,$nameImage);
                    } catch (Exception $e) {
                        Session::flash('error', 'No se pudo mover la imagen:'.$nameImage);
                    }
                }
            }
            if ($request->youtube!="") {
                Link::create([
                    'link' => $request->youtube,
                    'type' => 'youTube',
                    'solution_id'=>$solution->id
                ]);
            }
            if ($request->repositorio!="") {
                Link::create([
                    'link' => $request->repositorio,
                    'type' => 'Github',
                    'solution_id'=>$solution->id
                ]);
            }
            if ($request->web!="") {
                Link::create([
                    'link' => $request->web,
                    'type' => 'Facebook',
                    'solution_id'=>$solution->id
                ]);
            }

            Session::flash('message', 'Ea todo genial si funciono :D ');
            return redirect('/showSolution/'.$solution->id);

        }//end if de timeStatus and memStatus and compare
        else
        {
            return redirect()->route('solution.getFormSolution');
        }


    }

//    public function partialSolutions()
//    {
//        $idProblem = 10;
//        $problem = Problem::find($idProblem);
//        $solutions = $problem->solutionsPreview();
//        return view('solver.previewsSolution',compact('solutions'));
//
//    }

    public function mySolutions()
    {
        $user = auth()->user();
        $solutions = $user->mySolutions();
//        dd($solutions->toArray());
        return view('solver.mySolutions',compact('solutions'));
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
//        try {
            $code = @file_get_contents($solutionComplete->path);
//        dd($code);
            if(!$code===false)
            {
                $code=htmlspecialchars("\n".$code);
            }



//        } catch (ErrorException $e) {
//            Session::flash('error', 'Esta solución no tiene código que extraño, deberías reportarla');
//        }
        //dd($files->toArray());
        return view('solver.solution',compact('solutionComplete','images','code','audio','links','solution'));
    }

    public function deleteSolution($idSolution)
    {

        $solution = Solution::find($idSolution);
        $solutionDir=public_path().'/uploads/'.$solution->problem_id.'/solutions/'.$solution->id;
        $ownerSolution = $solution->user;
//        dd($solutionDir);
//        dd($solution->toArray(),$solution->user);
        if($ownerSolution->id == auth()->user()->getAuthIdentifier())
        {
            try {
                $solution->delete();//mantenemos el modelo
                CodeSolution::destroy($solution->codeSolution_id); //no mantenemos el modelo lo destruimos completamente
                Session::flash('message', 'Listo :D se ha borrado la solución : #'.$solution->id);
            } catch (Exception $e) {
                Session::flash('error', 'Paso algo extraño:'.$e->getMessage());
            }

            Tools::deleteDirectory($solutionDir); //borramos sus archivos del servidor
        }
        else
        {
            Session::flash('error', 'Creemos que esta solución no te pertenece lo sentimos no puedes borrarla :D');
        }
        return redirect()->route('solution.mySolutions');

    }

    public function getZipMultimediaSolution($idProblem,$idSolution)
    {
//        dd($idProblem,$idSolution);
        $zipRoot = public_path()."/uploads/".$idProblem."/solutions/".$idSolution."/";
        $zipName = "Problem".$idProblem."Solution".$idSolution.".zip";
        Tools::getZip($zipRoot,$zipName);


    }



}
