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
class TagsSeeder  extends Seeder {


    public function run()
    {
        $faker = Faker::create();

        for($i=0;$i<10;$i++)
        {

            Tag::create([

                'name'=> $faker->word,

            ]);
        }



    }






}