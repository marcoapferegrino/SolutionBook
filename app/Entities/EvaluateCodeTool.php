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
     public static $LIMIT_EXCECUTION_SERVER_SEGS=60;
     public static $RESULTS = array();
     public static $BASE_SENTENCE = "/usr/bin/time -f '%U->Tiempo de ejecución \n %M->Memory execution(kb) ' ";
     public static $PYTHON = "python ";
     public static $GCC = "clang ";
     public static $GCCPLUSPLUS = "clang++ -std=c++11 ";
     public static $JAVAC = "javac ";
     public static $JAVA = "java -cp ";
     public static $REDIRECT_OUTPUT = " 2>&1 ";
     public static $LIMIT_TIME = "timeout ";
     public static $BAD_WORDS = array('thread','exec','system','fork','pthread_t','pthread_create');

    /*
     * %E Elapsed real time (in [hours:]minutes:seconds).
     * %S Total number of CPU-seconds that the process spent in kernel mode.
     * %U Total number of CPU-seconds that the process spent in user mode.
     * */
     /**
      * @param $problem Problem
      * @param $fileCode
      * @param String $extension
      * @return array timeExecution, $timeStatus
      */

     static function evaluateCodeSolution($problem,$fileCode,$extension)
    {
        $faker = Faker::create();
        $nameFileCode   = $fileCode->getClientOriginalName();

        $inputFile = Files::where('problem_id',$problem->id)->where('type','fileinput')->first();
        $outputFile = Files::where('problem_id',$problem->id)->where('type','fileOutput')->first();

        $outputProblem = file_get_contents(public_path($outputFile->path));

        $outputProblem = self::withoutCarReturn($outputProblem);

        $fileCodeTemp = $fileCode->move("temporal/",$nameFileCode);
        $limitTime = self::getSeparetedTime($problem->limitTime);

        self::$RESULTS["pathCode"] = "temporal/".$fileCode->getClientOriginalName();
        self::$RESULTS['badWords']=false;

        $codeContent = file_get_contents(self::$RESULTS["pathCode"]);
        $badWords = self::getBadWords($codeContent);

        if (!empty($badWords)) {
            self::$RESULTS['badWords'] = true;
            Session::flash('error','Tu solución tiene funciones prohibidas:'.implode('-',$badWords));
            return self::$RESULTS;
        }

        switch($extension) {
            case 'c':
                $uniqueString=$faker->unique()->buildingNumber;
                $nameOutputFile = $problem->id . auth()->user()->getRememberToken().$uniqueString.".out";
                $sentenceCompile = self::$GCC . $fileCodeTemp->getRealPath() . " -o " . public_path() . "/temporal/" . $nameOutputFile .self::$REDIRECT_OUTPUT;

                exec($sentenceCompile,$outputCompile);
                if(empty($outputCompile))
                {
                    if ($problem->limitTime == "00:00:00"){
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_EXCECUTION_SERVER_SEGS." ./temporal/".$nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }
                    else{
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." "."./temporal/".$nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }
                    exec($sentenceToExecute,$output);
                    if (str_contains($output[count($output)-3],"Command exited with non-zero status")) {
                        Session::flash('error','Tu solución excedió el tiempo límite del Problema: '.$problem->limitTime." segs");
//                        redirect()->back();
                        }
                    else{
                        self::completeAndEvaluate($problem, $output, $outputProblem);

                        self::removeExecutable($nameOutputFile);

                        return self::$RESULTS;
                    }

                    break;
                }
                else{
                    self::$RESULTS['compileErrors']=Tools::cleanErrors($outputCompile);
                    self::removeExecutable($nameOutputFile);
                    return self::$RESULTS;
                }
                break;
            case 'cpp':
                $uniqueString=$faker->unique()->buildingNumber;
                $nameOutputFile = $problem->id . auth()->user()->getRememberToken().$uniqueString.".out";
                $sentenceCompile = self::$GCCPLUSPLUS . $fileCodeTemp->getRealPath() . " -o " . public_path() . "/temporal/" . $nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;

                exec($sentenceCompile,$outputCompile);
                if(empty($outputCompile))
                {

                    if ($problem->limitTime == "00:00:00"){
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_EXCECUTION_SERVER_SEGS." ./temporal/".$nameOutputFile." "." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }
                    else{
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." "."./temporal/".$nameOutputFile." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;

                    }
                    exec($sentenceToExecute,$output);
                    if (str_contains($output[count($output)-3],"Command exited with non-zero status")) {
                        Session::flash('error','Tu solución excedió el tiempo límite del Problema: '.$problem->limitTime." segs");
                    }
                    else{
                        self::completeAndEvaluate($problem, $output, $outputProblem);

                        self::removeExecutable($nameOutputFile);

                        return self::$RESULTS;
                    }

                    break;
                }
                else{
                    self::$RESULTS['compileErrors']=Tools::cleanErrors($outputCompile);
                    self::removeExecutable($nameOutputFile);
                    return self::$RESULTS;
                }

                break;
            case 'java':
                $sentenceCompile = self::$JAVAC.$fileCodeTemp->getRealPath().self::$REDIRECT_OUTPUT;
                $nameOutputFile = $fileCode->getClientOriginalName();
                $className = str_replace(".java","",$nameOutputFile);//File´s name is the Class´ name


                exec($sentenceCompile,$outputCompile);
                if(empty($outputCompile))
                {
                    if ($problem->limitTime == "00:00:00"){
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_EXCECUTION_SERVER_SEGS." ".self::$JAVA.public_path()."/temporal/ ".$className." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;

                    }
                    else{
                        $sentenceToExecute = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." ".self::$JAVA.public_path()."/temporal/ ".$className." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                    }

                    exec($sentenceToExecute,$output);

                    if (str_contains($output[count($output)-3],"Command exited with non-zero status")) {
                        Session::flash('error','Tu solución excedió el tiempo límite del Problema: '.$problem->limitTime." segs");
                    }
                    else{
                        self::completeAndEvaluate($problem, $output, $outputProblem);

                        self::removeExecutable($className.".class");

                        return self::$RESULTS;
                    }


                    break;
                }//end outputCompile
                else{
                    self::$RESULTS['compileErrors']=Tools::cleanErrors($outputCompile);
                    self::removeExecutable($nameOutputFile);
                    return self::$RESULTS;
                }
                break;
            case 'py':

                if ($problem->limitTime == "00:00:00"){
                    $sentence = self::$BASE_SENTENCE.self::$LIMIT_EXCECUTION_SERVER_SEGS." ".self::$PYTHON.$fileCodeTemp->getRealPath()." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                }
                else{
                    $sentence = self::$BASE_SENTENCE.self::$LIMIT_TIME.$limitTime[2]." ".self::$PYTHON.$fileCodeTemp->getRealPath()." < ".public_path($inputFile->path).self::$REDIRECT_OUTPUT;
                }
                exec($sentence,$output);
                if (str_contains($output[count($output)-3],"Command exited with non-zero status")) {
                    Session::flash('error','Tu solución excedió el tiempo límite del Problema: '.$problem->limitTime." segs");
                }
                else {
                    self::completeAndEvaluate($problem, $output, $outputProblem);
                    return self::$RESULTS;
                }
                break;
        }
    }


     /**
      * @param $outputProblem
      * @param $output
      */
     private static function evaluateOutputComparison ($outputProblem,$output)
     {
         /*Comparing original outputProblem with outputSolution for presententation and result*/
         $bool = strcmp($outputProblem,$output);
         /*Sending messages*/
         if($bool==0){
             self::$RESULTS['compare']=true;
             Session::flash('message', '¡Felicidades! La solución es correcta :D ');
         }
         else{
             self::$RESULTS['compare']=false;
             Session::flash('error', 'La salida no es igual');

         }
     }

     /**
      * regreso tiempo para guardarlo en code Solution en formato de time mySQL
      * @param $timeAndMem
      */
     private static function saveTimeAndMemory($timeAndMem)
     {
         self::$RESULTS['timeExecution'] = $timeAndMem['time'][0];
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
             Session::flash('error', ' Tu solución excedió el tiempo límite del Problema: Tu tiempo '.self::$RESULTS['timeExecution'].' Debería ser menor a: '.$timeProblemP);
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

//             $timeCodeTimestamp = \DateTime::createFromFormat('s.u', $timeAndMem['time'][0])->getTimestamp();
             $timeCodeTimestamp = $timeAndMem['time'][0];
             $memProblem = $problem->limitMemory;

             self::evaluateTime($timeCodeTimestamp, $problem->limitTime);
             self::evaluateMemory($timeAndMem['mem'][0], $memProblem);
         }
     }
     private static function getSeparetedTime($time){
         $time = explode(":",$time);
         return $time;
     }

     private static function getBadWords($contentFile)
     {
         $wordsFound=array();
         foreach(self::$BAD_WORDS as $bw)
         {
             if(str_contains($contentFile,$bw))
             {
                 array_push($wordsFound,$bw);
             }
         }
        return $wordsFound;

     }


     /**
      * @param $nameOutputFile
      * @return string error
      */
     private static function removeExecutable($nameOutputFile)
     {
         try {
             chown(public_path() . "/temporal/" . $nameOutputFile, "vagrant");
             unlink(public_path() . "/temporal/" . $nameOutputFile);
         } catch (\Exception $e) {
             return $e->getMessage();
         }
     }

     /**
      * @param $problem
      * @param $output
      * @param $outputProblem
      */
     private static function completeAndEvaluate($problem, $output, $outputProblem)
     {
         $outputToCompare = self::removeTwolastestPositions($output);
         $outputToCompare = implode("\n", $outputToCompare);
         self::evaluateOutputComparison($outputProblem, $outputToCompare);
         self::evaluateTimeAndMemory($problem, $output);
     }


 }