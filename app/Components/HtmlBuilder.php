<?php namespace SolutionBook\Components;

use Carbon\Carbon;
use Collective\Html\HtmlBuilder as CollectiveHtmlBuilder;
use Illuminate\Support\Facades\DB;
use SolutionBook\Entities\Notification;
use SolutionBook\Entities\User;

class HtmlBuilder extends CollectiveHtmlBuilder
{
    /**
     * Build an HTML class attribute dynamically
     * Usage:
     * {!! HTML::classes(['home'=>true,'main','dont use'=>false])!!}
     * @param array $classes
     * returns:
     * class="home main".
     * @return string
     */
    public function classes(array $classes)
    {
        $html = '';

        foreach ($classes as $name=>$bool )
        {
            if(is_int($name)){
                $name = $bool;
                $bool = true;
            }
            if($bool){
                $html .= $name.' ';
            }

        }
        if(!empty($html)){
            return ' class="'.trim($html).'"';
        }
        return '';

    }

    public static function icon( $type){

        if($type=='imagenEjemplo'||$type=='imagenApoyo'){

            return 'fa-file-image-o';

        }elseif($type=='notaVoz'){

            return 'fa-music';

        }elseif($type=='pdf'){

            return 'fa-file-pdf-o';
        }elseif($type=='word'){

            return 'fa-file-word-o';

        }

        return 'fa-file';
    }

    public static function dateEspañol($date){

        $date=str_replace('Jan','Enero',$date);
        $date=str_replace('Feb','Febrero',$date);
        $date=str_replace('Mar','Marzo',$date);
        $date=str_replace('Apr','Abril',$date);
        $date=str_replace('May','Mayo',$date);
        $date=str_replace('Jun','Junio',$date);
        $date=str_replace('Jul','Julio',$date);
        $date=str_replace('Aug','Agosto',$date);
        $date=str_replace('Sep','Septiembre',$date);
        $date=str_replace('Oct','Octubre',$date);
        $date=str_replace('Nov','Noviembre',$date);
        $date=str_replace('Dec','Diciembre',$date);





        return $date;
    }
    public static function stateEspañol($state){

        $state=str_replace('active','Activo',$state);
        $state=str_replace('blocked','Bloqueado',$state);
        $state=str_replace('suspended','Suspendido',$state);





        return $state;
    }
    public static function dateDiff($date){

        $fechaWell=HtmlBuilder::dateEspañol($date);
        $fecha1=Carbon::createFromFormat('Y-m-d H:i:s', $date);//->toDateTimeString();
       // $hoy=Carbon::now()->subHours(6)->diffInHours($fecha1,null);
        $hoy=$fecha1->diffInHours(Carbon::now(),null);
        if($hoy<24){

            if($hoy==0){

                $hoy=Carbon::now()->diffInMinutes($fecha1);
                if($hoy==0){

                    return 'Hace un momento' ;
                }
                if($hoy==1){

                    return 'Hace un minuto' ;
                }

                return 'Hace '. ($hoy). ' minutos' ;

            }
            elseif($hoy==1){

                return 'Hace una hora';
            }

            return 'Hace '.$hoy .'  horas';
        }
        else{
            $dias= floor($hoy / 24);
            if($dias==1){
                return  'Hace un'. ' día' ;

            }else{
                return  'Hace '. ($dias). ' días' ;
            }

        }


    }



    public static function obfuscater($value)
    {
        $safe = '';

        foreach (str_split($value) as $letter)
        {
            if (ord($letter) > 128) return $letter;

            // To properly obfuscate the value, we will randomly convert each letter to
            // its entity or hexadecimal representation, keeping a bot from sniffing
            // the randomly obfuscated letters out of the string on the responses.
            switch (rand(1, 3))
            {
                case 1:
                    $safe .= '&#'.ord($letter).';'; break;

                case 2:
                    $safe .= '&#x'.dechex(ord($letter)).';'; break;

                case 3:
                    $safe .= $letter;
            }
        }
        print_r($safe);
        return $safe;
    }

    public static function myId(){

        $user =  auth()->user();
        return $user->user_id;


    }

    public static function retrieveLikes(){

        $user =  auth()->user();
        //dd($user);
        $lik= DB::table('notifications')
            ->where('user_id','=',$user->id)
            //->where('user_id','=',11)
            // ->where('description','=','Like')
            ->where('viewed','=',0)->orderBy('created_at','desc')->get();


        // dd($lik,$user->id);
        //session(['MY_LIKES' => $lik]);
        session(['MY_LIKES' => $lik]);
        // dd(session('MY_LIKES'));
        //$request->session()->put('MY_LIKES', array());
        //return $likes;


    }
    public static function retrieveWarnings(){

       // $user =  auth()->user();
        //dd($user);
        $warnings= DB::table('warnings')
           // ->where('user_id','=',$user->id)
            //->where('user_id','=',11)
            // ->where('description','=','Like')
            ->where('state','=','forAdmin')->orderBy('created_at','desc')->get();


        // dd($lik,$user->id);
        //session(['MY_LIKES' => $lik]);
       // session(['MY_LIKES' => $lik]);
        // dd(session('MY_LIKES'));
        //$request->session()->put('MY_LIKES', array());
        return count($warnings);


    }
}