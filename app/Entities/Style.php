<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;

class Style extends Entity {

    protected $fillable = array('name','state','path');
    protected $table = 'styles';


    public static function css(){
        $stylo=Style::where('state','Activo')->get()->all();
        //dd("'".$stylo[0]->path."'");
        return $stylo[0]->path;
    }


}
