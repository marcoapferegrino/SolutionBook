<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 24/06/15
 * Time: 11:39
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Entity extends Model {


    public static function getClass()
    {
        return get_class(new static);
    }
}