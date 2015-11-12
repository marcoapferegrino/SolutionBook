<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 29/08/15
 * Time: 11:46
 */

namespace SolutionBook\Entities;

 use Illuminate\Support\Facades\Session;
 use Faker\Factory as Faker;

 class EvaluateCodeTool
{

     public static $RESULTS = array();
     public static $BASE_SENTENCE = "/usr/bin/time -f '%E->Tiempo de ejecución \n %M->Memory execution(kb) ' ";
     public static $PYTHON = "python ";
     public static $GCC = "clang ";
     public static $GCCMASMAS = "clang++ ";
     public static $JAVAC = "javac ";
     public static $JAVA = "java -cp ";
     public static $REDIRECT_OUTPUT = " 2>&1 ";
     public static $LIMIT_TIME = "timeout ";


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
        $faker = Faker::create();
        $nameFileCode   = $fileCode->getClientOriginalName();

        $inputFile = Files::where('problem_id',$problem->id)->where('type','fileinput')->first();
        $outputFile = Files::where('problem_id',$problem->id)->where('type','fileOutput')->first();
//        dd($inputFile->toArray(),$outputFile->toArray());

        /*File content String with newlines*/
        $outputProblem = file_get_contents(public_path($outputFile->path));
        $inputProblem = file_get_contents(public_path($inputFile->path));

         $outputProblem = self::withoutCarReturn($outputProblem);

//         dd($outputProblem);

        /*Removing newlines of Problem´s arguments*/
        $inputProblemString = self::withoutNewlines($inputProblem);
        $inputProblemString = self::withoutSpaces($inputProblemString);

        /*Removing newlines of Problem´s output to compare presentation*/
        $outputProblemString = self::withoutNewlines($outputProblem);
        $outputProblemString = self::withoutSpaces($outputProblemString);

         $fileCodeTemp = $fileCode->move("temporal/",$nameFileCode);
         $limitTime = self::getSeparetedTime($problem->limitTime);
//         dd($limitTime[2]);
//         dd($fileCodeTemp->getRealPath());
//         dd($inputProblemString,$outputProblemString);
         self::$RESULTS["pathCode"] = "temporal/".$fileCode->getClientOriginalName();
//         dd(self::$RESULTS["pathCode"]);
//        dd("Entre aqui en evaluateCodeSolution");

        switch($extension) {
            case 'c':
                $uniqueString=$faker->unique()->buildingNumber;
                $nameOutputFile = $problem->id . auth()->user()->getRememberToken().$uniqueString.".out";
//                dd($nameOutputFile);
                $sentenceCompile = self::$GCC . $fileCodeTemp->getRealPath() . " -o " . public_path() . "/temporal/" . $nameOutputFile .self::$REDIRECT_OUTPUT;

                exec($sentenceCompile,$outputCompile);
//                dd($outputCompile);
                if(empty($outputCompile))
                {
                    if ($problem->limitTime == "00:00:00"){
                        $sentenceToExecute = self::$BASE_SENTENCE."./temporal/".$nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }
                    else{
//                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." "."./temporal/".$nameOutputFile." ".$inputProblemString.self::$REDIRECT_OUTPUT;
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." "."./temporal/".$nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }
                    dd($sentenceToExecute);
                    exec($sentenceToExecute,$output);
//                    dd($output);
                    $outputToCompare = self::removeTwolastestPositions($output);
//                    dd($outputToCompare);
                    $outputToCompare = implode("\n",$outputToCompare);
//                    dd($outputToCompare);
                    self::evaluateOutputComparison($outputProblemString,$outputProblem,$outputToCompare);

                    self::evaluateTimeAndMemory($problem, $output);
                    unlink(public_path()."/temporal/".$nameOutputFile);
                    return self::$RESULTS;
                    break;
                }
                else{
                    unset($outputCompile[0]);
                    dd($outputCompile);
                }
                break;
            case 'cpp':
                $uniqueString=$faker->unique()->buildingNumber;
                $nameOutputFile = $problem->id . auth()->user()->getRememberToken().$uniqueString.".out";
//                dd($nameOutputFile);
                $sentenceCompile = self::$GCCMASMAS . $fileCodeTemp->getRealPath() . " -o " . public_path() . "/temporal/" . $nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;

                exec($sentenceCompile,$outputCompile);
//                dd($outputCompile);
                if(empty($outputCompile))
                {

                    if ($problem->limitTime == "00:00:00"){
                        $sentenceToExecute = self::$BASE_SENTENCE."./temporal/".$nameOutputFile." ".$inputProblemString.self::$REDIRECT_OUTPUT;
                    }
                    else{
//                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." "."./temporal/".$nameOutputFile." ".$inputProblemString.self::$REDIRECT_OUTPUT;
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." "."./temporal/".$nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;

                    }
//                    dd($sentenceToExecute);
                    exec($sentenceToExecute,$output);
//                    dd($output);
                    $outputToCompare = self::removeTwolastestPositions($output);
//                    dd($outputToCompare);
                    $outputToCompare = implode("\n",$outputToCompare);
//                    dd($outputToCompare);
                    self::evaluateOutputComparison($outputProblemString,$outputProblem,$outputToCompare);

                    self::evaluateTimeAndMemory($problem, $output);
                    unlink(public_path()."/temporal/".$nameOutputFile);
                    return self::$RESULTS;
                    break;
                }
                else{
                    unset($outputCompile[0]);
                    dd($outputCompile);
                }
                break;
            case 'java':
                $sentenceCompile = self::$JAVAC.$fileCodeTemp->getRealPath().self::$REDIRECT_OUTPUT;
                $nameOutputFile = $fileCode->getClientOriginalName();
                $className = str_replace(".java","",$nameOutputFile);//File´s name is the Class´ name

//               dd($sentenceCompile,$nameOutputFile,$className);

                exec($sentenceCompile,$outputCompile);
//                dd($sentenceCompile,$outputCompile);
                if(empty($outputCompile))
                {
                    if ($problem->limitTime == "00:00:00"){
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$JAVA.public_path()."/temporal/ ".$className." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;

                    }
                    else{
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." ".self::$JAVA.public_path()."/temporal/ ".$className." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }

//                    dd($sentenceToExecute);
                    exec($sentenceToExecute,$output);

                    if (str_contains($output[count($output)-3],"Command exited with non-zero status")) {
                        Session::flash('error','Tu solución excedió el tiempo límite del Problema: '.$problem->limitTime." segs");
                        redirect()->back();
                    }
                    else{
                        $outputToCompare = self::removeTwolastestPositions($output);
//                    dd($outputToCompare);
                        $outputToCompare = implode("\n",$outputToCompare);
//                    dd($outputToCompare);
//                    dd($sentenceToExecute,$outputToCompare,$output);
                        self::evaluateOutputComparison($outputProblemString,$outputProblem,$outputToCompare);

                        self::evaluateTimeAndMemory($problem, $output);
                        chown(public_path()."/temporal/".$className.".class","vagrant");
                        unlink(public_path()."/temporal/".$className.".class");
                        return self::$RESULTS;
                    }


                    break;
                }//end outputCompile
                else{
                    unset($outputCompile[0]);
                    dd($outputCompile);
                }
                break;
            case 'py':

                if ($problem->limitTime == "00:00:00"){
                    $sentence = self::$BASE_SENTENCE.self::$PYTHON.$fileCodeTemp->getRealPath()." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                }
                else{
                    $sentence = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." ".self::$PYTHON.$fileCodeTemp->getRealPath()." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
//                    $sentence = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." ".self::$PYTHON.$fileCodeTemp->getRealPath()." ".$inputProblemString.self::$REDIRECT_OUTPUT;
//                    $sentence = self::$BASE_SENTENCE.self::$PYTHON.$fileCodeTemp->getRealPath()." ".$inputProblemString.self::$REDIRECT_OUTPUT;
                }
//                dd($sentence);
                exec($sentence,$output);
//                dd($output);
                if (str_contains($output[count($output)-3],"Command exited with non-zero status")) {
                    Session::flash('error','Tu solución excedió el tiempo límite del Problema: '.$problem->limitTime." segs");
                    redirect()->back();
                }
                else {
//                dd($sentence,$output);
                    /*Removing time and memory of output*/
                    $outputToCompare = self::removeTwolastestPositions($output);
//                dd($outputToCompare);
                    /*Making output string*/
                    $outputToCompare = implode("\n", $outputToCompare);
//                dd($outputToCompare);
                    /*Comparing original outputProblem with outputSolution for presententation and result*/
//                dd($outputProblemString,$outputProblem,$outputToCompare);
                    self::evaluateOutputComparison($outputProblemString, $outputProblem, $outputToCompare);

                    /*Si la solución es igual a la del problema evaluamos tiempo y memoria*/
                    self::evaluateTimeAndMemory($problem, $output);

                    return self::$RESULTS;
                }
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
//         $boolPresentation = strcmp($outputProblemString,$output);
//         dd($outputProblem,$output);
         $bool = strcmp($outputProblem,$output);
         $RESULTS = "\n Solución de Problema:".$outputProblem."\n Tú solución: \n".$output;

         /*Sending messages*/
         if($bool==0){
             self::$RESULTS['compare']=true;
             self::$RESULTS['presentation']=true;
//             dd("soy igual todo bien");
             Session::flash('message', '¡Felicidades! La solución es correcta :D ');

         }
//         elseif($boolPresentation){
//             self::$RESULTS['compare']=true;
//             self::$RESULTS['presentation']=false;
//             dd("soy igual pero segun presentacion mal");
//             Session::flash('message', "Soy igual pero la presentación esta mal :(".$RESULTS);
//
//         }
         else{
             self::$RESULTS['compare']=false;
             self::$RESULTS['presentation']=false;
//             dd("Esto se fue al carajo");
             Session::flash('error', 'La salida no es igual');

         }
     }

     /**
      * regreso tiempo para guardarlo en code Solution en formato de time mySQL
      * @param $timeAndMem
      */
     private static function saveTimeAndMemory($timeAndMem)
     {
         self::$RESULTS['timeExecution'] = str_replace('.',':',$timeAndMem['time'][0]);
         self::$RESULTS['memUsed']=$timeAndMem['mem'][0];
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
             self::$RESULTS['timeStatus'] = true;
         }
         else
         {
             self::$RESULTS['timeStatus'] = false;
             //unlink($fileCode->getRealPath().$fileCode->getClientOriginalName());
             Session::flash('error', ' Tu solución excedió el tiempo límite del Problema: Tu tiempo '.self::$RESULTS['timeExecution'].' Debería ser menor a: '.$timeProblemP);
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
             self::$RESULTS['memStatus'] = true;
         }
         else
         {
             self::$RESULTS['memStatus'] = false;
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
                $extension = 'java';
                break;
            case 'python':
                $extension='py';
                break;
        }
        return $extension;
    }

     /**
      * @param $outputProblem
      * @return mixed|string
      */
     private static function withoutCarReturn($outputProblem)
     {
         $outputProblemS = urlencode($outputProblem);
         $outputProblemS = str_replace('%0D', "", $outputProblemS);
         $outputProblemS = urldecode($outputProblemS);
         return $outputProblemS;
     }

     /**
      * @param $problem
      * @param $output
      */
     private static function evaluateTimeAndMemory($problem, $output)
     {
         if (self::$RESULTS['compare']) {
             /*Evaluating time & Memory*/
             $timeAndMem = self::explodeMemAndTime($output);
             self::saveTimeAndMemory($timeAndMem);

             $timeCodeTimestamp = \DateTime::createFromFormat('H:i.s', $timeAndMem['time'][0])->getTimestamp();

             $memProblem = $problem->limitMemory;

             self::evaluateTime($timeCodeTimestamp, $problem->limitTime);
             self::evaluateMemory($timeAndMem['mem'][0], $memProblem);
         }
     }
     private static function getSeparetedTime($time){
         $time = explode(":",$time);
         return $time;
     }


 }