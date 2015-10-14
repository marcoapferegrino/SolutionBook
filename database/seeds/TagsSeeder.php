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

class TagsSeeder  extends Seeder {


    public function run()
    {
        $faker = Faker::create();
        $problems = Problem::all();

        for($i=0;$i<10;$i++)
        {

            Tag::create([

                'name'=> $faker->word,

            ]);
        }

        $tagsAll= Tag::all();
        foreach ($tagsAll as $tag){

            for($j=1;$j<rand(1,2);$j++){

                $problemL=Problem::find(rand(1,3));

                $tag->problem()->save($problemL);
            }
                //$problem->tags()->save($tag);

        }




    }






}