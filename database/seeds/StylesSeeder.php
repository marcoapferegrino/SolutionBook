<?php
/**
 * Created by PhpStorm.
 * User: luisknight
 * Date: 5/07/15
 * Time: 05:26 PM
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use SolutionBook\Entities\Tag;
use SolutionBook\Entities\Problem;

class StylesSeeder  extends Seeder {


    public function run()
    {
        \SolutionBook\Entities\Style::create([
            'name'=>'Default',
            'path'=> 'css/app.css',
            'state' => 'Activo'
        ]);

        \SolutionBook\Entities\Style::create([
            'name'=>'Temperance',
            'path'=> 'css/systemStyles/app1.css',
            'state' => 'No activo'
        ]);
        \SolutionBook\Entities\Style::create([
            'name'=>'Purple',
            'path'=> 'css/systemStyles/app2.css',
            'state' => 'No activo'
        ]);
        \SolutionBook\Entities\Style::create([
            'name'=>'Christmas?',
            'path'=> 'css/systemStyles/app3.css',
            'state' => 'No activo'
        ]);
        \SolutionBook\Entities\Style::create([
            'name'=>'Black',
            'path'=> 'css/systemStyles/app4.css',
            'state' => 'No activo'
        ]);




    }






}