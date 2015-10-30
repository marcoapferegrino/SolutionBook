<?php namespace SolutionBook\Components;

use Collective\Html\HtmlBuilder as CollectiveHtmlBuilder;

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
}