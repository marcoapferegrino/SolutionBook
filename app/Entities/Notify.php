<?php namespace SolutionBook\Entities;


class Notify {


    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }


    public static function encodeMsj($idDest,$idSolution,$idProblem,$type){

        $message='{';

        switch($type){
            case 'like':
            $solu=Solution::find($idSolution);
            $message.='"id":"'.$idDest.'",'.PHP_EOL;
            $message.='"message":"'.'¡Acabas de obtener un like!'.'",'.PHP_EOL;
            $message.='"solution":"'.$idSolution.''.PHP_EOL;

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