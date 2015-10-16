<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 29/08/15
 * Time: 11:46
 */

namespace SolutionBook\Entities;

 use Illuminate\Support\Facades\Session;

 class EvaluateCodeTool
{

     public static $results = array();
     public static $baseSentence = "/usr/bin/time -f '%E->Tiempo de ejecución \n %M->Memory execution(kb)' python ";
     public static $redirectOutput = " 2>&1";

     public static $pythonSentence  = " python ";
     public static $cCompilationSentence="gcc";
     /**
      * @param $problem Problem
      * @param $fileCode
      * @param String $extension
      * @return array timeExecution, $timeStatus
      */
     /*
      * Revisar cuando código esta mal
      * Revisar cuando Los tiempos y memoria de problema son libres
      * */
     static function evaluateCodeSolution($problem,$fileCode,$extension)
    {

        $inputFile = Files::where('problem_id',$problem->id)->where('type','fileinput')->first();
        $outputFile = Files::where('problem_id',$problem->id)->where('type','fileOutput')->first();
//        dd($inputFile->toArray(),$outputFile->toArray());

        /*File content String with newlines*/
        $outputProblem = file_get_contents(public_path($outputFile->path));
        $inputProblem = file_get_contents(public_path($inputFile->path));
//        dd($inputProblem,$outputProblem);
        /*Removing newlines of Problem´s arguments*/
        $inputProblemString = self::withoutNewlines($inputProblem);
        $inputProblemString = self::withoutSpaces($inputProblemString);

        /*Removing newlines of Problem´s output to compare presentation*/
        $outputProblemString = self::withoutNewlines($outputProblem);
        $outputProblemString = self::withoutSpaces($outputProblemString);

//         dd($inputProblemString,$outputProblemString);

//        dd("Entre aqui en evaluateCodeSolution");
        switch($extension) {
            case 'c':

                break;
            case 'cpp':

                break;
            case 'class':

                break;
            case 'py':
                /*Executing python program*/
//                exec("time -f '%E->Tiempo de ejecución \n %M->Memory execution(kb) 'python 1 2 3 2>&1",$salida);
//                dd($salida);
                $sentence=self::$baseSentence.$fileCode->getRealPath().".py"." ".$inputProblemString.self::$redirectOutput;
//                dd($sentence);
                exec($sentence,$output);
                dd($output);
                /*Removing time and memory of output*/
                $outputToCompare = self::removeTwolastestPositions($output);
                dd($outputToCompare);
                /*Making output string*/
                $outputToCompare = implode("\n",$outputToCompare);

                /*Comparing original outputProblem with outputSolution for presententation and result*/

                self::evaluateOutputComparison($outputProblemString,$outputProblem,$outputToCompare);

                /*Si la solución es igual a la del problema evaluamos tiempo y memoria*/
                if (self::$results['compare']) {
                    /*Evaluating time & Memory*/
                    $timeAndMem = self::explodeMemAndTime($output);
                    self::saveTimeAndMemory($timeAndMem);

                    $timeCodeTimestamp = \DateTime::createFromFormat('H:i.s',$timeAndMem['time'][0])->getTimestamp();

                    $memProblem = $problem->limitMemory;

                    self::evaluateTime($timeCodeTimestamp,$problem->limitTime);
                    self::evaluateMemory($timeAndMem['mem'][0],$memProblem);
                }

                return self::$results;
                break;
        }
    }

     /**
      * @internal Comparing original outputProblem with outputSolution for presententation and result
      * @param $outputProblemString
      * @param $outputProblem
      * @param $output
      */
     private static function evaluateOutputComparison ($outputProblemString,$outputProblem,$output)
     {

         /*Comparing original outputProblem with outputSolution for presententation and result*/
         $boolPresentation = strcmp($outputProblemString,$output);
         $bool = strcmp($outputProblem,$output);
         $results = "\n Solución de Problema:".$outputProblem."\n Tú solución: \n".$output;

         /*Sending messages*/
         if($bool==0){
             self::$results['compare']=true;
             self::$results['presentation']=true;
             Session::flash('message', 'Solución correcta'.$results);
         }
         elseif($boolPresentation){
             self::$results['compare']=true;
             self::$results['presentation']=false;
             Session::flash('message', "Soy igual pero la presentación esta mal :(".$results);

         }
         else{
             self::$results['compare']=false;
             self::$results['presentation']=false;
             Session::flash('message', 'La salida no es igual debería ser:'.$results);

         }
     }

     /**
      * regreso tiempo para guardarlo en code Solution en formato de time mySQL
      * @param $timeAndMem
      */
     private static function saveTimeAndMemory($timeAndMem)
     {
         self::$results['timeExecution'] = str_replace('.',':',$timeAndMem['time'][0]);
         self::$results['memUsed']=$timeAndMem['mem'][0];
     }

     /**
      * Compare Problem´s time with Solution´s time
      * @param $timeCodeTimestamp
      * @param $timeProblemP
      */
     private static function evaluateTime($timeCodeTimestamp,$timeProblemP)
     {
         $timeProblem = strtotime($timeProblemP);

         if ($timeProblemP == "00:00:00" || $timeCodeTimestamp <= $timeProblem )
         {
             self::$results['timeStatus'] = true;
         }
         else
         {
             self::$results['timeStatus'] = false;
             //unlink($fileCode->getRealPath().$fileCode->getClientOriginalName());
             Session::flash('error', 'Excedio el límite de tiempo de ejecución: Tu tiempo '.self::$results['timeExecution'].' Debería ser menor a: '.$timeProblemP);
             //return redirect()->route('solution.getFormSolution');
         }
     }

     /**
      * Compare Problem´s memory with Solution´s memory
      * @param $memUsed
      * @param $memProblem
      */
     private static function evaluateMemory ($memUsed,$memProblem)
     {
         if($memUsed <= $memProblem ||$memProblem == 0)
         {
             self::$results['memStatus'] = true;
         }
         else
         {
             self::$results['memStatus'] = false;
             //unlink($fileCode->getRealPath().$fileCode->getClientOriginalName());
             Session::flash('error', 'Excedio el límite de memoria:'.'Usaste:'.$memUsed.' kb'.' Debería ser menor a : '.$memProblem.' kb');
             //return redirect()->route('solution.getFormSolution');
         }
     }


     /**
      * return just tehe time and memory without other text
      * @param $output
      * @return array
      */
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

     /**
      * Removing newlines of Problem´s arguments
      * @param $inputProblema
      * @return mixed|string
      */
     private static function withoutNewlines ($inputProblema)
     {

         $inputProblema = urlencode($inputProblema);
         $inputProblema = str_replace('%0A'," ",$inputProblema);
         $inputProblema = str_replace('%0D'," ",$inputProblema);
         $inputProblema = preg_replace('[\s+]'," ",$inputProblema); //varios espacios por solo uno

//         $inputProblema = str_replace('%0D%0A'," ",$inputProblema);dd($inputProblema);
         return $inputProblema;
     }

     private static function withoutSpaces ($outputProblemString)
     {
        return str_replace('+'," ",$outputProblemString);
     }

     /**
      * Removing texts time and memory of output
      * @param $output
      * @return mixed
      */
     private static function removeTwolastestPositions ($output)
     {
         unset($output[count($output)-1]);
         unset($output[count($output)-1]);

         return $output;
     }




     /**
      * Return extension according with the language
      * @param $language
      * @return string
      */
     public static function getExtentionByLanguage($language)
    {
        $extension ="";
        switch($language)
        {
            case 'c':
                $extension='c';
                break;
            case 'c++':
                $extension = 'cpp';
                break;
            case 'java':
                $extension = 'class';
                break;
            case 'python':
                $extension='py';
                break;
        }
        return $extension;
    }



}