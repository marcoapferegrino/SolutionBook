<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SolutionBook\Entities;

class Tag extends Entity {


    protected $fillable = ['name'];


    public function problem()
    {
        return $this->belongsToMany(Problem::getClass(), 'problem_tag'); // pertenece a muchos problemas

    }
    public static function similarTags($p){
        $sql="SELECT * FROM `tags` WHERE name like '%$p%' order by case when name LIKE '$p' then 0 when name LIKE '$p%' then 1 when name LIKE '%$p%' then 2 when name LIKE '%$p' then 3 else 4 end, name";

        $result= \DB::select(DB::raw($sql));
        return $result;
    }


}
