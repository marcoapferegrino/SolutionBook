<?php
/**
 * Created by PhpStorm.
 * User: luisknight
 * Date: 5/07/15
 * Time: 05:26 PM
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\Tag;
<<<<<<< HEAD
use App\Entities\Problem;
=======
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178
class TagsSeeder  extends Seeder {


    public function run()
    {
        $faker = Faker::create();

<<<<<<< HEAD
        $problems = Problem::all();
=======
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178
        for($i=0;$i<10;$i++)
        {

            Tag::create([

                'name'=> $faker->word,

            ]);
        }

<<<<<<< HEAD
        $tagsAll= Tag::all();
        foreach ($tagsAll as $tag){

            for($j=1;$j<rand(1,2);$j++){

                $problemL=Problem::find(rand(1,3));

                $tag->problem()->save($problemL);
            }
                //$problem->tags()->save($tag);

        }

        /*
        $tagsAll= Tag::all();
        foreach ($problems as $problem){

            for($j=1;$j<rand(1,5);$j++){

                $tag=Tag::find($j);
                $problem->tags()->save($tag);
            }

        }
        */


=======
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178


    }






}