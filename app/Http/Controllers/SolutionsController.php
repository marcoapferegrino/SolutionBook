<?php

namespace SolutionBook\Http\Controllers;

use Carbon\Carbon;
use Exception;
use SolutionBook\Entities\CodeSolution;
use SolutionBook\Entities\Files;
use SolutionBook\Entities\Like;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Solution;
use SolutionBook\Entities\EvaluateCodeTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests\AddSolutionRequest;
use SolutionBook\Http\Requests\UpdateSolutionRequest;

use SolutionBook\Http\Requests;


class SolutionsController extends Controller
{

    public static $TAGS_ALLOWED = "<strong><p><b><code><h3><h2><h4><kbd>";
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
        $user = auth()->user();
        $idProblem      = $request->idProblem;
        $idUser         = $user->id;;

        $images         = $request->file('images');
        $fileCode       = $request->file('fileCode');
        $audioFile      = $request->file('audioFile');
        $language       = $request->optionsLanguages;

        $problem        = Problem::find($idProblem);
        $numSolutions   = $problem->numSolutions;
        

        $nameFileCode   = $fileCode->getClientOriginalName();
        $extension      = EvaluateCodeTool::getExtentionByLanguage($language);
        $results        = EvaluateCodeTool::evaluateCodeSolution($problem, $fileCode, $extension);

        if (!empty($results['badWords']) ==true) {
            return redirect()->back();
        }
        if (!empty($results['compileErrors'])) {
            $compileErrors=$results['compileErrors'];
            return view('errors.errorsCode',compact('compileErrors','idProblem'));
        }

        $timeExplo = explode('.',$results['timeExecution']);

        if ($results['compare'] && $results['timeStatus'] && $results['memStatus']) { //si pasa la prueba de memoria y tiempo
            $codeSolution = CodeSolution::create([
                'language'          => $language,
                'path'              => '', //path donde esta el codigo fuente
                'limitTime'         => $results['timeExecution'],//tiempo de ejecucion del codigo
                'limitTimeString'   => Tools::getTimeFromSeconds($timeExplo[0]).".".$timeExplo[1],
                'limitMemory'       => $results['memUsed'], //memoria usada por el codigo

            ]);

            $solution = Solution::create([
                'explanation'       =>  strip_tags($request->explanation,self::$TAGS_ALLOWED),
                'state'             =>  'active',
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

            //guardando Código
            if ($fileCode->getClientOriginalExtension() == $extension)
            {
                try {
                    $pathTemporal = public_path()."/".$results["pathCode"];
                    $pathNow = public_path()."/".$pathCode.$nameFileCode;

                    chown($pathTemporal,"vagrant");
                    if (!rename($pathTemporal,$pathNow)) {
                        Session::flash('error', 'No se pudo mover el archivo del código');
                    }
                } catch (Exception $e) {
                    Session::flash('error', 'Sucedio algo extraño :(');
                }
            }

            if($audioFile!=null)
            {
                Files::saveAudio($audioFile,$solution->id,$pathAudioFile);
            }
            //guardando imagenes
            if ($images[0]!=null) {
                Files::saveImages($images,$solution->id,$pathImages);
            }

            Files::addOrReplaceLink($request->youtube,$solution->id,'YouTube');
            Files::addOrReplaceLink($request->repositorio,$solution->id,'Repositorio');
            Files::addOrReplaceLink($request->web,$solution->id,'Web');

            $problem->numSolutions = $numSolutions+1;
            $problem->save();

            $user->ranking+=env('POINTS_PER_SOLUTION');
            $user->save();

            Session::flash('message', '¡Felicidades! La solución es correcta :D');
            return redirect('/showSolution/'.$solution->id);

        }//end if de timeStatus and memStatus and compare
        else //time and memory fail
        {
            return redirect()->back();
        }


    }

    public function mySolutions()
    {
        $user = auth()->user();
        $solutions = $user->mySolutions();
//        dd($solutions->toArray());
        if (count($solutions)==0) {
            Session::flash('error', 'Lista vacía');
        }
        return view('solver.mySolutions',compact('solutions'));
    }

    public function showSolution($idSolution)
    {
        //dd($id);
        $solutionPart = Solution::findOrFail($idSolution);
//        dd($solutionPart->toArray());
        $images = Files::where('solution_id',$solutionPart->id)->where('type','imagenApoyo')->get();
        $audio = Files::where('solution_id',$solutionPart->id)->where('type','notaVoz')->get();
        $solution = $solutionPart->solutionComplete();

//        dd($idSolution);
        $links = Link::where('solution_id',intval($idSolution))
            ->where('type','<>','Referencia')
            ->where('type','<>','Amonestación')->get();

        try {
            $code = @file_get_contents($solution->path);
//        dd($code);
            if(!$code===false)
            {
                $code=htmlspecialchars("\n".$code);
            }

        } catch (\ErrorException $e) {
            Session::flash('error', 'Esta solución no tiene código que extraño, deberías reportarla');
        }
        $title  = "Solución id ".$solutionPart->id." del Problema ".$solution->problem_id;
        $id     = $solutionPart->id;
        $url    = "showSolution";
        //dd($files->toArray());
        return view('solver.solution',compact('images','code','audio','links','solution','title','id','url'));
    }

    public function deleteSolution($idSolution)
    {

        $solution = Solution::find($idSolution);
        $problem = Problem::find($solution->problem_id);

        $solutionDir=public_path().'/uploads/'.$solution->problem_id.'/solutions/'.$solution->id;
        $ownerSolution = $solution->user;
//        dd($solutionDir);
//        dd($solution->toArray(),$solution->user);
        if($ownerSolution->id == auth()->user()->getAuthIdentifier())
        {
            try
            {
                $solution->delete();//mantenemos el modelo
                CodeSolution::destroy($solution->codeSolution_id); //no mantenemos el modelo lo destruimos completamente

                Session::flash('message', 'Se ha eliminado correctamente: la solución : #'.$solution->id." Y estas en Mis Soluciones");

                Tools::deleteDirectory($solutionDir); //borramos sus archivos del servidor

                $problem->numSolutions-=1;
                $problem->save();

                $ownerSolution->ranking-=env('POINTS_PER_SOLUTION');
                $ownerSolution->save();

            } catch (Exception $e) {
                Session::flash('error', 'Paso algo extraño:'.$e->getMessage());
            }
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
        unlink(public_path().'/'.$zipName);//eliminamos el zip del server

    }
    public function orderSolutions(Request $request)
    {
        $language = $request->get('language');
        $restriction = $request->get('restriction');
        $idProblem = $request->get('idProblem');
        $problem = Problem::find($idProblem);
        $solutions = $problem->solutionsPreviewOrdered($language,$restriction);

//      dd($language,$restriction,$idProblem,$solutions);
        return view('solver.previewsSolutionsOrdered',compact('solutions','idProblem'));

    }

    public function getUpdateSolution($id)
    {
        $user = auth()->user();

        $solution = Solution::find($id);
        $warnings = Warning::where('solution_id',$solution->id)->where('state','process')->get();
//        dd($warnings->toArray());
        if (count($warnings)>0) {
            Session::flash('error',"Esta solución tiene amonestaciones corrigela por favor.");
        }


        if ($solution->user_id == $user->id) {
            $images = Files::where('solution_id',$solution->id)->where('type','imagenApoyo')->get();
            $audio = Files::where('solution_id',$solution->id)->where('type','notaVoz')->get();
            $solutionComplete = $solution->solutionComplete();
            $linkYouTube = Link::all()->where('solution_id',intval($solution->id))->where('type','YouTube')->first();
            $linkGitHub = Link::all()->where('solution_id',intval($solution->id))->where('type','Repositorio')->first();
            $linkWeb = Link::all()->where('solution_id',intval($solution->id))->where('type','Web')->first();
//            dd($solutionComplete);

//            dd($solution,$links);
//            dd($links->toArray());
            try {
                $code = @file_get_contents($solutionComplete->path);

                if(!$code===false)
                {
                    $code=htmlspecialchars("\n".$code);
                }

            } catch (ErrorException $e) {
                Session::flash('error', 'Esta solución no tiene código que extraño, deberías reportarla');
            }
            return view('solver.updateSolution',compact('solution','images','code','audio','solutionComplete','linkYouTube','linkGitHub','linkWeb','warnings'));
        } else {

            Session::flash("error","Lo sentimos esta solución no es de tu propiedad.");
            return redirect()->back();
        }
    }

    public function updateSolution(UpdateSolutionRequest $request)
    {
//        dd($request->all());
        $fileCode       = $request->file('fileCode');
        $audioFile      = $request->file('audioFile');

        $path ='uploads/'.$request->idProblem.'/solutions/'.$request->idSolution.'/';
        $pathImages = $path.'images/';
        $pathAudioFile   = $path.'audio/'; //path donde guardaré audio
        $pathCode   = $path.'code/'; //path donde guardaré el código

        $solution = Solution::find($request->idSolution);
        $problem = Problem::find($request->idProblem);
        $codeSolution = CodeSolution::find($solution->codeSolution_id);

        $solution->explanation = $request->explanation;
        $imgsDelete= $request->imgsDelete;

        //Si modifica el código corremos las pruebas de nuevo y reseteamos los likes a 0
        if ($fileCode != null || $fileCode = "") {
            $nameFileCode   = $fileCode->getClientOriginalName();
            $extension      = EvaluateCodeTool::getExtentionByLanguage($codeSolution->language);
            $results        = EvaluateCodeTool::evaluateCodeSolution($problem, $fileCode, $extension);

            if ($results['compare'] && $results['timeStatus'] && $results['memStatus']) { //si pasa la prueba de memoria y tiempo

                $codeSolution->limitTime    = $results['timeExecution'];
                $codeSolution->limitMemory  = $results['memUsed'];
                $solution->numLikes         = 0;//borrar registros de likes no solo reiniciar el contador
                $likes = Like::where('solution_id',$solution->id)->delete();


                if ($fileCode->getClientOriginalExtension() == $extension)
                {
                    try {
                        $pathTemporal = public_path()."/".$results["pathCode"];
                        $pathNow = public_path()."/".$pathCode.$nameFileCode;

                        exec("rm -r ".public_path()."/".$codeSolution->path);
                        chown($pathTemporal,"vagrant");

                        if (!rename($pathTemporal,$pathNow)) { //movemos el archivo al nuevo path
                            Session::flash('error', 'No se pudo mover el archivo del código');
                        }
                        $codeSolution->path=$pathNow;
                        $codeSolution->save();
                    } catch (Exception $e) {
                        Session::flash('error', 'Sucedio algo extraño :(');
                    }
                }
            }
            else //time and memory fail
            {
                return redirect()->back();
            }

        }


        Files::addOrReplaceLink($request->youtube,$solution->id,'YouTube');
        Files::addOrReplaceLink($request->repositorio,$solution->id,'Repositorio');
        Files::addOrReplaceLink($request->web,$solution->id,'Web');
        $solution->state = 'active';
        $solution->save();

        if($imgsDelete!=null){
            foreach ($request->imgsDelete as $img ) {
                $file = Files::find($img);
                unlink($file->path);
                $file->delete();
            }
        }

        if ($request->images[0]!=null) {
            Files::saveImages($request->images,$solution->id,$pathImages);
        }

        if($audioFile!=null)
        {
            Files::saveAudio($audioFile,$solution->id,$pathAudioFile);
        }
        Warning::expireWarnings('solution_id',$solution->id);

        Session::flash('message', 'Cambios guardados');
        return redirect('/showSolution/'.$solution->id);
    }



}
