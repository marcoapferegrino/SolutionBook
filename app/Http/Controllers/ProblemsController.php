<?php

namespace SolutionBook\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use SolutionBook\Entities\JudgesList;
use Illuminate\Http\Request;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Tag;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\ProblemasTags;

use Illuminate\Support\Facades\Session;

use SolutionBook\Entities\Warning;
use SolutionBook\Http\Requests\AddProblemRequest;
use SolutionBook\Http\Requests\UpdateProblemRequest;
use SolutionBook\Entities\Files;
use SolutionBook\Http\Requests;


class ProblemsController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function addProblem(AddProblemRequest $request)
    {
               // dd($request);
        $title=$request->title;
        $idUser= auth()->user()->getAuthIdentifier();
        $nameUser= auth()->user()->username;
        $institution= $request->institucion;
        $description= $request->descripcion;
        $limitTime= $request->limitTime;
        $limitMem= $request->limitMemory;
        $judge= $request->judgeList;
        $ejemploen=$request->ejemploen;
        $ejemplosa=$request->ejemplosa;
        $input= $request->inputs;
        $output= $request->outputs;
        $tags= $request->tags;
        $images= $request->images;
        $youtube= $request->youtube;
        $github= $request->github;
        $web= $request->web;
        $share=$request->share;

        if($judge=='#'){
            $judge=null;
        }

        if(is_numeric($limitTime)&&$limitTime!=0){
            $horas = floor($limitTime / 3600);
            $minutos = floor(($limitTime - ($horas * 3600)) / 60);
            $segundos = $limitTime - ($horas * 3600) - ($minutos * 60);
        }
        else{
            $horas=0;
            $minutos = 0;
            $segundos =0;
        }
        //dd($images);

        $problem=Problem::create([
            'title'=>$title,
            'author'=>$nameUser,
            'institution'=> $institution,
            'description'=> strip_tags($description,self::$TAGS_ALLOWED),
            'numSolutions' =>0,
            'limitTime'=> $horas.':'.$minutos.':'.$segundos,
            'limitMemory' => $limitMem,
            'numWarnings' => 0,
            'state' => 'active',
            'share'=>($share!=null)?$share:'no',
            'judgeList_id'=>$judge,
            'user_id' => $idUser,

        ]);
        $problem->save();
        $idProblem= $problem->id;
        $path ='uploads/'.$idProblem.'/';
        $pathEjem = $path.'ejemplos/';
        $pathInput= $path.'inputs/';
        $pathOutput= $path.'outputs/';
        //dd($images);
        if($images[0]!=null){
            foreach ($images as $image)
            {
                $find='image';
                $pos=strpos($image->getClientMimeType(),$find);

                if($pos === false){
                    $find='pdf';
                    $pos=strpos($image->getClientMimeType(),$find);
                    $pathImages = $path.'docs/';
                    if($pos === false)
                        $tipo='word';
                    else
                        $tipo='pdf';
                }
                else{
                    $tipo="imagenApoyo";
                    $pathImages = $path.'images/';
//                    mkdir($pathImages,0755, true);
                }
                $nameImage = $image->getClientOriginalName();

                $fileImage = Files::create([
                    'name' => $nameImage,
                    'path' => $pathImages.$nameImage,
                    'type'=>$tipo,
                    'problem_id'=>$idProblem,
                ]);
                $fileImage->save();

                $image->move($pathImages,$nameImage);
            }
        }

        mkdir($pathEjem,null, true);
        Files::create([
            'name' => 'entrada',
            'path' => $pathEjem.'entrada.txt',
            'type'=>'ejEntrada',
            'problem_id'=>$idProblem,
        ]);
        Files::create([
            'name' => 'salida',
            'path' => $pathEjem.'salida.txt',
            'type'=>'ejSalida',
            'problem_id'=>$idProblem,
        ]);

        $fp = fopen($pathEjem.'entrada.txt', "w");
        fputs($fp, $ejemploen);
        fclose($fp);

        $fp = fopen($pathEjem.'salida.txt', "w");
        fputs($fp, $ejemplosa);
        fclose($fp);



        $in=$input;//foreach($input as $i=>$in){
        $nameIn="input0.txt";
        $namePathIn=$pathInput.$nameIn;
        Files::create([
            'name' => $nameIn,
            'path' => $namePathIn,
            'type'=>'fileinput',
            'problem_id'=>$idProblem,
        ]);
        mkdir($pathInput,0755, true);
        $fp = fopen($namePathIn, "w");
        fputs($fp, $in);
        fclose($fp);
        // }

        $out=$output;//foreach($output as $i=>$out){
        $nameOut="output0.txt";
        $namePathOut=$pathOutput.$nameOut;
        Files::create([
            'name' => $nameOut,
            'path' => $namePathOut,
            'type'=>'fileOutput',
            'problem_id'=>$idProblem,
        ]);
        mkdir($pathOutput,0755, true);
        $fp = fopen($namePathOut, "w");
        fputs($fp, $out);
        fclose($fp);

        // }

        Files::addOrReplaceLink($youtube,$idProblem,'YouTube',1);
        Files::addOrReplaceLink($github,$idProblem,'Repositorio',1);
        foreach($web as $w){
            if($w!=null){
                Link::create([
                    'link' => $w,
                    'type' => 'Web',
                    'problem_id' => $idProblem
                ]);
            }
        }

        if($tags!="")
        {
            $palabrasClave=explode(",",$tags);
            foreach ($palabrasClave as $key => $tag) {
                # code...
                if($tag!=''and$tag!=null){
                    $existe=Tag::where('name','=',$tag)->first();
                    if(!$existe){
                        $existe=Tag::create(['name'=>$tag]);
                    }
                    ProblemasTags::create(['tag_id'=>$existe->id,'problem_id'=>$idProblem]);
                }

            }

        }

        Session::flash('message', 'Tu problema fue agregado con éxito');
        return redirect()->route('problem.showProblem',$idProblem);

    }

    public function allProblems()
    {
        //->groupBy('problems.id')
        $result= \DB::table('problems')
            ->select('id','limitTime','limitMemory','title','numSolutions','numWarnings','user_id','created_at')
            ->paginate(9);
        $avatar=array();
        $publicado=array();
        foreach($result as $r){
            $img=Files::whereRaw('problem_id = '.$r->id.' and type = "imagenApoyo"')->first();
            if($img!=null)
                array_push($avatar,$img->path);
            else
                array_push($avatar,'default.jpg');
            array_push($publicado,Carbon::parse($r->created_at));
        }
        $placeholder="Buscar por: Título o Tags";
        $dias=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        $meses=array('0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

        return view('problem/allProblems',compact('result','avatar','placeholder','dias','meses','publicado'));
    }
    public function addFormProblem()
    {
        //
        //$result = \DB::table('judges_lists')->get();
        $judgeList= JudgesList::all('id','name');

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
        $problem=Problem::find($id);
        $idUser= auth()->user()->getAuthIdentifier();

        if($problem->user_id==$idUser)
        {
            $problem->update(['user_id'=>1,'author'=>'SolutionBook']);
            Session::flash('message', 'Se ha eliminado correctamente');
        }
        else
            Session::flash('error', 'No tienes permitido realizar esta acción');
        $result= \DB::table('problems')->where('problems.user_id','=',$idUser)->paginate(9);

        return redirect()->back();

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
        $filesAll=Problem::find($idProblem)->files;
        $tagsAll=Problem::find($idProblem)->tags;
        //$files=Problem::find($idProblem)->tags;
        $tags='';
        $judge=JudgesList::find($dataProblem->judgeList_id);

        foreach ($tagsAll as $key => $t) {
            # code...
            $tag=Tag::find($t->tag_id);
            if($key==0)
                $tags.=$tag->name;
            else
                $tags.=','.$tag->name;

        }

        $problemLIS = Problem::find($idProblem);
        $links=Link::where('problem_id','=',$problemLIS->id)
            ->where('type','<>','Referencia')
            ->where('type','<>','Amonestación')->get();

        $problem = Problem::find($idProblem);
        $solutions = $problem->solutionsPreview();
        $files = array();$entrada="";$salida="";
        $docs = array();
        foreach($filesAll as $f ){
            $type=$f->type;
            if($type=='ejEntrada'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                $entrada=$text;
            }
            elseif($type=='ejSalida'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                $salida=$text;
            }
            elseif($type=='imagenApoyo'){
                array_push($files,$f);
            }
            elseif($type=='pdf'||$type=='word'){
                array_push($docs,$f);
            }
        }
        $dias=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        $meses=array('0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $publicado= Carbon::parse($dataProblem->created_at);
        $cSolutions         = count($dataProblem->SolutionsPerLanguage('c'));
        $cplusSolutions     = count($dataProblem->SolutionsPerLanguage('c++'));
        $pythonSolutions    = count($dataProblem->SolutionsPerLanguage('python'));
        $javaSolutions      = count($dataProblem->SolutionsPerLanguage('java'));
        $title  = $dataProblem->title;
        $id     = $dataProblem->id;
        $url    = "showProblem";
        $idsProblemas=ProblemasTags::tablaProblemasSimilares($tags,1);
        $idsProblemas=array_unique($idsProblemas);
        if($idsProblemas!=null){
            $clave=array_search($idProblem, $idsProblemas);
            unset($idsProblemas[$clave]);
            $idsProblemas=array_values($idsProblemas);
            if($idsProblemas!=null)
                $problemasSimilares=Problem::problemasPorId($idsProblemas);
            else
                $problemasSimilares=null;
        }
        else
            $problemasSimilares=null;
        //dd($problemasSimilares);
        return view('problem/showProblem',compact('dias','meses','publicado','tags','judge','dataProblem','files',
            'entrada','salida','docs','links','solutions','cSolutions',
            'cplusSolutions','pythonSolutions','javaSolutions','title','id','url','problemasSimilares'));
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
    public function updateProblem(UpdateProblemRequest $request)
    {
        //dd($request->all());
        $idProblem=$request->idProblem;
        $title=$request->title;
        $nameUser= auth()->user()->username;
        $institution= $request->institucion;
        $description= $request->descripcion;
//        $limitTime= $request->limitTime;
//        $limitMem= $request->limitMemory;
        $judge= $request->judgeList;
        $ejemploen=$request->ejemploen;
        $ejemplosa=$request->ejemplosa;
//        $input= $request->inputs;
//        $output= $request->outputs;
        $tags= $request->tags;
        $images= $request->images;
        $youtube= $request->youtube;
        $github= $request->github;
        $web=$request->web;
        $imgsDelete= $request->imgsDelete;
        $linksDelete= $request->linksDelete;
        $share=$request->share;
        if($judge=='#'){
            $judge=null;
        }
//        if(is_numeric($limitTime)&&$limitTime!=0){
//            $horas = floor($limitTime / 3600);
//            $minutos = floor(($limitTime - ($horas * 3600)) / 60);
//            $segundos = $limitTime - ($horas * 3600) - ($minutos * 60);
//        }
//        else{
//            $horas=0;
//            $minutos = 0;
//            $segundos =0;
//        }
         $warnings = Warning::where('problem_id',$idProblem)->where('state','process')->get();
//        dd($warnings->toArray());
        if (count($warnings)>0) {
            Session::flash('error',"Este problema tiene amonestaciones corrigelo por favor.");
        }
        $problem=Problem::find($idProblem);
        $problem->update([
            'title'         =>$title,
            'author'        =>$nameUser,
            'institution'   => $institution,
            'description'   => $description,
//            'limitTime'=> $horas.':'.$minutos.':'.$segundos,
//            'limitMemory' => $limitMem,
            'share'         =>($share!=null)?$share:'no',
            'judgeList_id'  =>$judge,
            'state'         => 'active'
        ]);
        $problem->save();
        $path ='uploads/'.$idProblem.'/';
        $pathEjem = $path.'ejemplos/';
        $pathInput= $path.'inputs/';
        $pathOutput= $path.'outputs/';
        //dd($images);

        if($linksDelete!=null){
            foreach ($linksDelete as $l ) {
                $link = Link::find($l);
                $link->delete();
            }
        }
        Files::addOrReplaceLink($youtube,$idProblem,'YouTube',1);
        Files::addOrReplaceLink($github,$idProblem,'Repositorio',1);
        foreach($web as $w){
            if($w!=null){
                Link::create([
                    'link' => $w,
                    'type' => 'Web',
                    'problem_id' => $idProblem
                ]);
            }
        }

        if($imgsDelete!=null){
            foreach ($request->imgsDelete as $img ) {
                $file = Files::find($img);
                unlink($file->path);
                $file->delete();
            }
        }
        if($images[0]!=null){
            foreach ($images as $image)
            {
                $find='image';
                $pos=strpos($image->getClientMimeType(),$find);
                echo $pos."\n";
                if($pos === false){
                    $find='pdf';
                    $pos=strpos($image->getClientMimeType(),$find);
                    $pathImages = $path.'docs/';
                    if($pos === false)
                        $tipo='word';
                    else
                        $tipo='pdf';
                }
                else{
                    $tipo="imagenApoyo";
                    $pathImages = $path.'images/';
                }
                $nameImage = $image->getClientOriginalName();

                $fileImage = Files::create([
                    'name' => $nameImage,
                    'path' => $pathImages.$nameImage,
                    'type'=>$tipo,
                    'problem_id'=>$idProblem,
                ]);
                $fileImage->save();

                $image->move($pathImages,$nameImage);
            }
        }



        $fp = fopen($pathEjem.'entrada.txt', "w");
        fputs($fp, $ejemploen);
        fclose($fp);

        $fp = fopen($pathEjem.'salida.txt', "w");
        fputs($fp, $ejemplosa);
        fclose($fp);



//        $in=$input;//foreach($input as $i=>$in){
//        $nameIn="input0.txt";
//        $namePathIn=$pathInput.$nameIn;
//        $fp = fopen($namePathIn, "w");
//        fputs($fp, $in);
//        fclose($fp);
//        // }
//
//        $out=$output;//foreach($output as $i=>$out){
//        $nameOut="output0.txt";
//        $namePathOut=$pathOutput.$nameOut;
//        $fp = fopen($namePathOut, "w");
//        fputs($fp, $out);
//        fclose($fp);

        // }
        $tagsActuales=Problem::find($idProblem)->tags;
        if($tags!="")
        {
            $palabrasClave=explode(",",$tags);
            foreach($tagsActuales as $eachTag){
                $tagActual=Tag::find($eachTag->tag_id)->name;
                if(!in_array($tagActual,$palabrasClave))
                {
                    $existe=Tag::where('name',$tagActual)->first();
                    $relacionPT=ProblemasTags::relacionPT($idProblem,$existe->id);
                    //dd($relacionPT);
                    $relacionPT->delete();
                }
            }
            foreach ($palabrasClave as $key => $tag) {
                # code...
                if($tag!=''and$tag!=null){
                    $existe=Tag::where('name','=',$tag)->first();
                    if(!$existe){
                        $existe=Tag::create(['name'=>$tag]);
                    }
                    $existeRelacion=ProblemasTags::relacionPT($idProblem,$existe->id)->first();

                    if(!$existeRelacion)
                        ProblemasTags::create(['tag_id'=>$existe->id,'problem_id'=>$idProblem]);
                }

            }

        }
        Warning::expireWarnings('problem_id',$problem->id);

        Session::flash('message', 'Cambios guardados');
        return redirect()->route('problem.showProblem',$idProblem);


    }

    public function updateGetProblem($idProblem)
    {
        //
        $dataProblem=Problem::find($idProblem);
        if($dataProblem->user_id!=auth()->user()->getAuthIdentifier()){
            Session::flash('error', 'No tienes permitido realizar esta acción');
            return redirect()->back();
        }
        $filesAll=Problem::find($idProblem)->files;
        $tagsAll=Problem::find($idProblem)->tags;
        //$files=Problem::find($idProblem)->tags;
        $tags='';
        foreach ($tagsAll as $key => $t) {
            # code...
            $tag=Tag::find($t->tag_id);
            if($key==0)
                $tags.=$tag->name;
            else
                $tags.=','.$tag->name;

        }
//        $warnings=Problem::find($idProblem)->warnings;

        $youtube=Link::where('type','=','YouTube')->where('problem_id','=',$idProblem)->first();
        $github=Link::where('type','Repositorio')->where('problem_id',$idProblem)->first();
        $url=Link::where('type','Web')->where('problem_id',$idProblem)->get();
//        dd($youtube,$github,$url);

        $judgeList= JudgesList::all('id','name');
//      $solutions=Problem::find(10)->solutions;

        $problem = Problem::find($idProblem);
        $solutions = $problem->solutionsPreview();
        $files = array();$entrada="";$salida="";$inputs="";$outputs="";
        $docs = array();
        foreach($filesAll as $f ){
            $type=$f->type;
            if($type=='ejEntrada'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                $entrada=$text;
            }
            elseif($type=='ejSalida'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                $salida=$text;
            }
            elseif($type=='fileinput'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= (filesize($f->path)>0)?fread($myfile,filesize($f->path)):"";
                fclose($myfile);
                $inputs=$text;
            }
            elseif($type=='fileOutput'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= (filesize($f->path)>0)?fread($myfile,filesize($f->path)):"";
                fclose($myfile);
                $outputs=$text;
            }
            elseif($type=='imagenApoyo'||$type=='pdf'||$type=='word'){
                array_push($files,$f);
            }
            else{
                array_push($docs,$f);
            }
        }
        /*foreach ($links as $l) {
            # code...
            if($l->type=='YouTube')
                $youtube=$l;
            if($l->type=='Github')
                $github=$l;

        }*/
        $limitTime=Carbon::parse($dataProblem->limitTime);
        $segh=$limitTime->hour*3600;
        $segm=$limitTime->minute*60;
        $dataProblem->limitTime=$limitTime->second+$segh+$segm;
        //dd($files);
        //dd($solutions);

        return view('problem/updateProblem',compact('url','tags','dataProblem','judgeList','files','entrada','salida','inputs','outputs','docs','github','youtube','solutions'));

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



    public function similarProblems($cadena)
    {
        //
        $result= Problem::similarTitle($cadena);
        $similares='';
        if(!$result){
            $similares="No hay problemas similares";
        }
        elseif (count($result)==0) {
            $similares="Problemas 0 similares";
        }
        else{
            $similares='<table class="table table-hover">';
            foreach ($result as $key => $r) {
                # code...
                $similares .='<tr><td><a href='.route('problem.showProblem',$r->id).' > '.$r->title.'</a></td></tr>';
                if($key>=3)
                    break;
            }
            $similares .='</table>';
        }
        echo $similares;
    }

    public function similarTags($cadena)
    {
        //
        if($cadena=='a#')
            return " ";
        $similares='';
        echo ProblemasTags::tablaProblemasSimilares($cadena);
    }

    public function getZipMultimediaProblem($idProblem)
    {
        //    dd($idProblem);
        $zipRoot = public_path()."/uploads/".$idProblem."/";
        $zipName = "Problem".$idProblem.".zip";
        Tools::getZip($zipRoot,$zipName,1);
        unlink(public_path().'/'.$zipName);//eliminamos el zip del server

    }
    public function findProblem(Request $request)
    {
        //
        $cadena=$request->buscar;
        $avatar = array();
        $idBuscar=array();
        $publicado=array();
        $idsProblemas=array();
        if($cadena!="")
        {
            $result= Problem::similarTitle($cadena);
            $similares='';
            if(!$result){
                $similares="No hay problemas similares";
            }
            else{
                foreach($result as $r){
                    array_push($idsProblemas,$r->id);
                }
            }
            $problemasPorTags=ProblemasTags::tablaProblemasSimilares($cadena,1);
            foreach($problemasPorTags as $addId)
            {
                array_push($idsProblemas,$addId);
            }
            $idsProblemas=array_unique($idsProblemas);
            if($idsProblemas==null){
                Session::flash('error', 'No se encontraron coincidencias');
                return redirect()->back();
            }
            else{
                $result=Problem::problemasPorId($idsProblemas);
                foreach($idsProblemas as $id){
                    $img=Files::whereRaw('problem_id = '.$id.' and type = "imagenApoyo"')->first();
                    if($img!=null)
                        array_push($avatar,$img->path);
                    else
                        array_push($avatar,'default.jpg');
                    array_push($publicado,Carbon::parse(Problem::find($id)->created_at));
                }
            }
            //dd($result);
        }
        else{
            return redirect()->back();
        }
        $placeholder="Buscar por: Título o Tags";
        $dias=array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        $meses=array('0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

        return view('problem/allProblems',compact('cadena','result','avatar','placeholder','dias','meses','publicado'));
        //dd($request);

    }



}
