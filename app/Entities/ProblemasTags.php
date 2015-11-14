<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProblemasTags extends Entity {

    protected $fillable = ['tag_id','problem_id'];

    protected $table = 'problem_tag';

    public static function similarProblemsfromTags($idBuscar){
        $sql="SELECT problem_id, count(problem_id) from problem_tag where tag_id in (";
        foreach ($idBuscar as $key => $id) {
            # code...
            if($key==0)
                $sql.="".$id." ";
            else
            $sql.=",".$id."";

        }
        $sql.=") group by problem_id, problem_id order by count(problem_id) desc";
//echo $sql;
        $result= \DB::select(DB::raw($sql));
        return $result;
    }

    public static function relacionPT($problema,$tag){
        return ProblemasTags::whereRaw('tag_id ='.$tag.' and problem_id = '.$problema);
    }

    public static function tablaProblemasSimilares($cadena,$type=null){
        $idBuscar=array();
        $similares='<table class="table table-hover">';
        $palabras = explode(",",$cadena);
        foreach($palabras as $p){
            $result= Tag::similarTags($p);

            if(!$result){
                $similares="No hay problemas similares ";
            }
            else{
                foreach ($result as $key => $r) {
                    # code...
                    //$similares .='<tr><td><a href='.route('problem.showProblem',$r->id).' > '.$r->name.'</a></td></tr>';
                    if($key>=3)
                        break;
                    array_push($idBuscar, $r->id);
                }
            }
        }
        //dd($idBuscar);
        if($type!=null)
        {
            $idsProblemas=array();
            if($idBuscar!=[]) {
                $result = ProblemasTags::similarProblemsfromTags($idBuscar);
                if (!$result) {
                    $similares = "No hay problemas similares";
                } else {
                    foreach ($result as $key => $r) {
                        array_push($idsProblemas,$r->problem_id);
                    }
                }
            }
            return $idsProblemas;
        }
        if($idBuscar==[]){
            $similares="No hay problemas similares ";
        }else{
            $result= ProblemasTags::similarProblemsfromTags($idBuscar);
            if(!$result){
                $similares="No hay problemas similares";
            }
            else{
                foreach ($result as $key => $r) {
                    # code...
                    $problema=Problem::find($r->problem_id);
                    $similares .='<tr><td><a href='.route('problem.showProblem',$problema->id).' > '.$problema->title.'</a></td></tr>';
                    if($key>=5)
                        break;
                }
            }
            $similares .='</table>';
        }

        //dd($result);
        return $similares;
    }
}