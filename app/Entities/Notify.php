<?php namespace SolutionBook\Entities;


class Notify {


    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }
}