<?php

namespace SolutionBook\Http\Controllers;

use SolutionBook\Entities\JudgesList;
use Illuminate\Http\Request;
use SolutionBook\Entities\Problem;
use SolutionBook\Entities\Link;

use Illuminate\Support\Facades\Session;
use SolutionBook\Entities\User;
use SolutionBook\Http\Requests\AddProblemRequest;
use SolutionBook\Entities\Files;
use SolutionBook\Http\Requests;
use SolutionBook\Http\Controllers\Controller;
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
    public function addProblem(AddProblemRequest $request)
    {
        //        dd($request);
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

        if($judge='#'){
            $judge=null;
        }
        $problem=Problem::create([
            'title'=>$title,
            'author'=>$nameUser,
            'institution'=> $institution,
            'description'=> $description,
            'numSolutions' =>0,
            'limitTime'=> $limitTime,
            'limitMemory' => $limitMem,
            'numWarnings' => 0,
            'state' => 'active',
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
        $find='image';
        print_r($images);
        if($images[0]!=null){
            foreach ($images as $image)
            {
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
        if($youtube!=null){
            Link::create([
                'link' => $youtube,
                'type' => 'youTube',
                'problem_id'=>$idProblem,
            ]);
        }

        if($github!=null){
            Link::create([
                'link' => $github,
                'type' => 'Github',
                'problem_id'=>$idProblem,
            ]);
        }

        Session::flash('message', 'Se agregó exitosamente a la base de datos');
        return redirect()->route('problem.addFormProblem');

    }

    public function allProblems()
    {
        //->groupBy('problems.id')
        $result= \DB::table('problems')
            ->select('problems.id as pid ','limitTime','title','problems.description as description','numWarnings','user_id')
            ->paginate(9);
        $avatar=array();
        foreach($result as $r){
            $usuario=User::find($r->user_id);
            array_push($avatar,$usuario->avatar);
        }

        return view('problem/allProblems',compact('result','avatar'));
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
        $filesAll=Problem::find($idProblem)->files;
       // $files=Problem::find($idProblem)->judgeList;
        //$files=Problem::find($idProblem)->tags;

//        $warnings=Problem::find($idProblem)->warnings;

        $links=Problem::find($idProblem)->links;

//      $solutions=Problem::find(10)->solutions;

        $problem = Problem::find($idProblem);
        $solutions = $problem->solutionsPreview();
        $files = array();
        $inputs= array();
        $outputs = array();
        $docs = array();
        foreach($filesAll as $f ){
            $type=$f->type;
            if($type=='fileinput'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                array_push($inputs,$text);
            }
            elseif($type=='fileOutput'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                array_push($outputs,$text);
            }
            elseif($type=='imagenApoyo'){
                array_push($files,$f);
            }
            else{
                array_push($docs,$f);
            }
        }
        //dd($files);
        //dd($solutions);
        return view('problem/showProblem',compact('dataProblem','files','inputs','outputs','docs','links','solutions'));
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
    public function updateProblem(Request $request)
    {
        //
        dd($request);
    }

    public function updateGetProblem($idProblem)
    {
        //

        $dataProblem=Problem::find($idProblem);
        $filesAll=Problem::find($idProblem)->files;
        // $files=Problem::find($idProblem)->judgeList;
        //$files=Problem::find($idProblem)->tags;

//        $warnings=Problem::find($idProblem)->warnings;

        $links=Problem::find($idProblem)->links;

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
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                $inputs=$text;
            }
            elseif($type=='fileOutput'){
                $myfile = fopen($f->path, "r") or die("Unable to open file!");
                $text= fread($myfile,filesize($f->path));
                fclose($myfile);
                $outputs=$text;
            }
            elseif($type=='imagenApoyo'){
                array_push($files,$f);
            }
            else{
                array_push($docs,$f);
            }
        }
        //dd($files);
        //dd($solutions);
        return view('problem/updateProblem',compact('dataProblem','judgeList','files','entrada','salida','inputs','outputs','docs','links','solutions'));

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
        $condicion='CASE WHEN title like a% THEN 0  WHEN title like % %a% % THEN 1 WHEN title like %a THEN 2  ELSE 3 END';
        $sql="SELECT * FROM `problems` WHERE title like '%$cadena%' order by case when title LIKE '$cadena' then 0 when title LIKE '$cadena%' then 1 when title LIKE '%$cadena%' then 2 when title LIKE '%$cadena' then 3 else 4 end, title";
        $result= \DB::select(DB::raw($sql));
        //$result= \DB::table('problems')->where('title','like',"%$cadena%")->orderByRaw('case when title LIKE "$cadena%" then 1 when title LIKE "%$cadena%" then 2 when title LIKE "%$cadena" then 3 else 4 end')->get();
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
        $similares='';

        $similares='<table class="table table-hover">';
        $palabras = explode(",",$cadena);
        foreach($palabras as $p){
            $sql="SELECT * FROM `tags` WHERE name like '%$p%' order by case when name LIKE '$p' then 0 when name LIKE '$p%' then 1 when name LIKE '%$p%' then 2 when name LIKE '%$p' then 3 else 4 end, name";

            $result= \DB::select(DB::raw($sql));

            if(!$result){
                $similares="No hay problemas similares";
            }
            elseif (count($result)==0) {
                $similares="Problemas 0 similares";
            }
            else{
                foreach ($result as $key => $r) {
                    # code...
                    $similares .='<tr><td><a href='.route('problem.showProblem',$r->id).' > '.$r->name.'</a></td></tr>';
                    if($key>=3)
                        break;
                }
            }
        }

        $similares .='</table>';
        echo $similares;
    }







}
