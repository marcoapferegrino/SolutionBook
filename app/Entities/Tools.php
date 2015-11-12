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

}