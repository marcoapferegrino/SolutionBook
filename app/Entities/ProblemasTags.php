<?php namespace SolutionBook\Entities;

use Illuminate\Database\Eloquent\Model;
class ProblemasTags extends Entity {

    protected $fillable = ['tag_id','problem_id'];

    protected $table = 'problem_tag';

}