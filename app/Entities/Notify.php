<?php namespace SolutionBook\Entities;


use SolutionBook\Components\HtmlBuilder;

class Notify {

    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }


    public static function encodeMsj($idDest,$idSolution,$idProblem,$type,$date){

        $idPublic=null;
        $url='/myWarnings';
        if($idSolution==null){
            $idPublic=$idProblem;
//            $url='/showProblem/';

        }elseif($idProblem==null){
            $idPublic=$idSolution;
           // $url='/showSolution/';

        }

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

                $message.='"id":"'.$idDest.'",';
                $message.='"message":"'.'¡Acabas de ser amonestado en tu publicación!'.'",';
                $message.='"date":"'.HtmlBuilder::dateDiff($date).'",';
                //$message.='"url":"'.$url.$idPublic.'",';
                $message.='"url":"'.$url.'",';
                $message.='"public":'.$idPublic.'';
                


                break;



            case 'promoted':

                $message.='"id":"'.$idDest.'",';
                $message.='"message":"'.'¡Acabas de ser promovido a Problem Setter!'.'",';
                $message.='"date":"'.HtmlBuilder::dateDiff($date).'",';
                //$message.='"url":"'.$url.$idPublic.'",';
                $message.='"url":"'.'/userPerfil/'.$idDest.'"';

                break;

            case 'dePromoted':


                $message.='"id":"'.$idDest.'",';
                $message.='"message":"'.'Tu cuenta fue cambiada a Solver'.'",';
                $message.='"date":"'.HtmlBuilder::dateDiff($date).'",';
                //$message.='"url":"'.$url.$idPublic.'",';
                $message.='"url":"'.'/userPerfil/'.$idDest.'"';

                break;



        }




        $message.='}';
        return $message;


    }
 }