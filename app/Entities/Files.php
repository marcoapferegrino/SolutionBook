<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;

class Files extends Entity {

	protected $fillable = ['name','path','description','type','solution_id','problem_id','notice_id'];

    public function notice(){
    	return $this->belongsTo(Notice::getClass());
    }
    public function solution(){
    	return $this->belongsTo(Solution::getClass());
    }
    public function problem(){
    	return $this->belongsTo(Problem::getClass());
    }

    public static function saveAudio($audioFile, $idSolution, $pathAudioFile)
    {
        exec("rm -r ".$pathAudioFile);
        $nameAudioFile  = $audioFile->getClientOriginalName();
        if ($audioFile->getClientOriginalExtension() == "mp3")
        {
            try {
                $fileAudio = Files::create([
                    'name' => $nameAudioFile,
                    'path' => $pathAudioFile.$nameAudioFile,
                    'type'=>'notaVoz',
                    'solution_id'=>$idSolution,
                ]);

                $fileAudio->save();
                $audioFile->move($pathAudioFile,$nameAudioFile);
//                dd("guarde File Aqui");
            } catch (Exception $e) {
                Session::flash('error', 'No se pudo mover el archivo del audio');
            }
        }

    }
    public static function saveImages($images,$idSolution,$pathImages)
    {
        foreach ($images as $image)
        {   $nameImage = $image->getClientOriginalName();
            try {

                $fileImage = Files::create([
                    'name' => $nameImage,
                    'path' => $pathImages.$nameImage,
                    'type'=>'imagenApoyo',
                    'solution_id'=>$idSolution,
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
    /**
     * @param UpdateSolutionRequest $request
     * @param $solution
     */
    public static function addOrReplaceLink($linkRequest, $idTarget,$type,$owner=null)
    {
        //$owner=1 ->  problems : solutions
        if ($linkRequest != null && $linkRequest != " "&& $linkRequest != "") {

            $linkAux = Link::where(($owner==1)?'problem_id':'solution_id', $idTarget)->where('type', $type)->first();
//            dd($linkAux);
            if ($linkAux == null) {
//                dd($linkRequest);
                Link::create([
                    'link' => $linkRequest,
                    'type' => $type,
                    ($owner==1)?'problem_id':'solution_id' => $idTarget
                ]);

            } else {
//                dd($request->YouTube);
                $linkAux->link = $linkRequest;
                $linkAux->save();

            }

        }
    }

    public static function getGallery($id)
    {
        $usernames = DB::table('files')
            ->select('path')
            ->where('notice_id',$id)
            ->where('type','imagenGallery')
            ->get();

        return $usernames;



    }


}
