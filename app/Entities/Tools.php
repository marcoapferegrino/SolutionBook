<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 17/10/15
 * Time: 15:12
 */

namespace SolutionBook\Entities;

use Illuminate\Support\Facades\Session;

class Tools
{
    public static function getZip($path,$name,$type=null)
    {
        $zipName=$name;
        $zipRoot=$path;

        $zip = new \ZipArchive();
        $zip->open($zipName, \ZipArchive::CREATE);

        if($type==null)
        {
            $files = self::getFilesbyDirectory($zipRoot);
            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($zipRoot));

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
        else{
            $files = self::getFilesbyDirectory($zipRoot."inputs/");
            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($zipRoot));

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $files = self::getFilesbyDirectory($zipRoot."outputs/");
            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($zipRoot));

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }



        // Zip archive will be created only after closing object
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipName);
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);

    }

   public static function deleteDirectory($dir) {
       try {
           if (!file_exists($dir)) {
               return true;
           }

           if (!is_dir($dir)) {
               return unlink($dir);
           }

           foreach (scandir($dir) as $item) {
               if ($item == '.' || $item == '..') {
                   continue;
               }

               if (!self::deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                   return false;
               }
           }
           return rmdir($dir);

       } catch (\Exception $e) {
           Session::flash('error', 'Paso algo extraño'.$e->getMessage());
       }
    }

    /**
     * @param int $seconds
     * @return string
     */
    public static function getTimeFromSeconds($seconds)
    {
        $init = $seconds;
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;

        return  "$hours:$minutes:$seconds";
    }





    /**
     * @param $zipRoot
     * @return \RecursiveIteratorIterator
     */
    private static function getFilesbyDirectory($zipRoot)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($zipRoot),
            \RecursiveIteratorIterator::LEAVES_ONLY);
        return $files;
    }

    public static function sendEmail($email,$name,$subject,$reason)
    {

        $view = "emails.genericEmail";
        $data = self::dataforEmailByReason($reason);

        \Mail::send($view,$data, function($message) use ($email,$name,$subject)
        {
            $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
            $message->subject($subject);
            $message->to($email,$name);

        });
    }

    /**
     * @param $reason
     * @param $data
     * @return mixed
     */
    private static function dataforEmailByReason($reason)
    {
        switch ($reason) {
            case "promotion":
                $data['title'] = "Hola has sido ascendido a Problem Setter. Recuerda es una gran responsabilidad :D";
                $data['subtitle'] = "Detrás de un gran poder viene una gran responsabilidad";
                $data['content'] = "Ahora tienes la capacidad de agregar Problemas para la comunidad pero recuerda no es tarea sencilla debes ser responsable :D";
                break;
            case "unpromotion":
                $data['title'] = "Hola ahora eres un Solver de nuevo";
                $data['subtitle'] = "Recuerda que debes explicar tus soluciones detalladamente para subir de nivel y ayudar a la comunidad :D";
                $data['content'] = "No te rindas puedes regresar a ser un Problem setter: subiendo audios con la explicación, links de apoyo para los usuarios o diagramas con ejemplos incluso atendiendo dudas";

                break;
            case "addProblemSetter":
                $data['title'] = "Ahora eres un Problem Setter en SolutionBook";
                $data['subtitle'] = "Por favor explica los problemas y sube imagenes de apoyo como diagramas o ejemplos asi como links de ayuda con los temas o un audio explicando";
                $data['content'] = "Ahora tienes la capacidad de agregar Problemas para la comunidad pero recuerda no es tarea sencilla debes ser responsable :D";
                break;
            case "addSolver":
                $data['title'] = "Te has registrado como un Solver Felicidades";
                $data['subtitle'] = "Ahora eres un Solver empieza a solucionar problemas";
                $data['content'] = "Recuerda que al hacer soluciones ayudaras a la comunidad por favor explica tus soluciones";
                break;
            case "addWarning":
                $data['title'] = "Tienes una amonestación";
                $data['subtitle'] = "Por favor revisa tus amonestaciones";
                $data['content'] = "Tienes que editar el contenido o si crees que es falsa ignorala el administrador se encargará de deliberar. Recuerda que es para mejorar el contenido de la web.";
                break;
        }

        return $data;
    }
    public static function cleanErrors($codeArray){
        $codeArrayCleaned= array();

        for ($i=0;$i<count($codeArray);$i++) {
            $codeArrayCleaned[$i]=str_replace("/home/vagrant/Code/SolutionBook/public/temporal/","",$codeArray[$i]);
        }
        return $codeArrayCleaned;
    }

}