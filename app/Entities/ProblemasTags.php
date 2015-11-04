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
            $sql.=",".$id."";

        }
        $sql.=") group by problem_id, problem_id order by count(problem_id) desc";
//echo $sql;
        $result= \DB::select(DB::raw($sql));
        return $result;
    }
}