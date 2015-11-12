<?php namespace SolutionBook\Entities;


use SolutionBook\Components\HtmlBuilder;

class Notify {

    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }


    public static function encodeMsj($idDest,$idSolution,$idProblem,$type,$date){

        $message='{';

        switch($type){
            case 'like':
            $solu=Solution::find($idSolution);
            $message.='"id":"'.$idDest.'",';
            $message.='"message":"'.'¡Acabas de obtener un like!'.'",';
            $message.='"date":"'.HtmlBuilder::dateDiff($date).'",';
            $message.='"url":"'.'/showSolution/'.$idSolution.'",';
            $message.='"solution":'.$idSolution.'';

                break;


            case 'warning':

                break;



            case 'promoted':

                break;



        }




        $message.='}';
        return $message;


    }
 }