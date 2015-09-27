<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 29/08/15
 * Time: 11:46
 */

namespace App\Entities;


 use Illuminate\Support\Facades\Session;

 class Tools extends Entity
{

     public static $results = array();

     /**
      * @param $problem Problem
      * @param $fileCode File
      * @param String $extension
      * @return array timeExecution, $timeStatus
      */
     static function evaluateCodeSolution($problem,$fileCode,$extension)
    {
        switch($extension) {
            case 'c':

                break;
            case 'cpp':

                break;
            case 'class':

                break;
            case 'py':
                exec("/usr/bin/time -f '%E->Tiempo de ejecución \n %M->Memory execution(kb)' python ".$fileCode->getRealPath()." 2>&1",$output);

                $timeAndMem = self::explodeMemAndTime($output);

                self::$results['timeExecution'] = str_replace('.',':',$timeAndMem['time'][0]); //regreso tiempo para guardarlo en code Solution en formato de time mySQL
                self::$results['memUsed']=$timeAndMem['mem'][0];

                $timeCodeTimestamp = \DateTime::createFromFormat('H:i.s',$timeAndMem['time'][0])->getTimestamp();

                $memProblem= $problem->limitMemory;

                self::evaluateTimeAndMemory($timeCodeTimestamp,$problem->limitTime,$timeAndMem['mem'][0],$memProblem);

                //$memory = self::convert(memory_get_usage(true));
                return self::$results;
                break;
        }
    }

     private static function evaluateTimeAndMemory($timeCodeTimestamp,$timeProblemP,$memUsed,$memProblem)
     {
         $timeProblem = strtotime($timeProblemP);
         if ($timeCodeTimestamp <= $timeProblem)
         {
             self::$results['timeStatus'] = true;
         }
         else
         {
             self::$results['timeStatus'] = false;
             //unlink($fileCode->getRealPath().$fileCode->getClientOriginalName());
             Session::flash('error', 'Excedio el limite de tiempo de ejecución: Tu tiempo '.self::$results['timeExecution'].' Debería ser menor a: '.$timeProblemP);
             //return redirect()->route('solution.getFormSolution');
         }

         if($memUsed <= $memProblem)
         {
             self::$results['memStatus'] = true;
         }
         else
         {
             self::$results['memStatus'] = false;
             //unlink($fileCode->getRealPath().$fileCode->getClientOriginalName());
             Session::flash('error', 'Excedio el limite de memoria:'.'Usaste:'.$memUsed.' kb'.' Debería ser menor a : '.$memProblem.' kb');
             //return redirect()->route('solution.getFormSolution');
         }

     }

     private static function explodeMemAndTime($output)
     {
         $fin    =   count($output);
         $mem    =   explode("->",$output[$fin-1]);
         $time   =   explode("->",$output[$fin-2]);

         $output = array('time'=>$time,'mem'=>$mem);

         return $output;
     }

     private static function convert($size)
     {
         $unit=array('b','kb','mb','gb','tb','pb');
         return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
     }



}