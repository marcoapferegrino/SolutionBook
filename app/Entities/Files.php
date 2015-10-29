<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

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

    public static function icon( $type){

        if($type=='imagenEjemplo'||$type=='imagenApoyo'){

            return 'fa-file-image-o';

        }elseif($type=='notaVoz'){

             return 'fa-music';

        }elseif($type=='pdf'){

            return 'fa-file-pdf-o';
        }elseif($type=='word'){

            return 'fa-file-word-o';

        }

        return 'fa-file';
    }

}
