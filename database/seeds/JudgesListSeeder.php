<?php
/**
 * Created by PhpStorm.
 * User: luisknight
 * Date: 5/07/15
 * Time: 06:28 PM
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\JudgesList;
class JudgesListSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        for($i=0;$i<10;$i++)
        {

            JudgesList::create([

                'name'=> $faker->text(),
                'addressWeb' =>$faker->url,
//                'contact' =>$faker->name,
                'facebook' =>$faker->name,
                'twitter' =>"@". $faker->name,
                'image' =>"A/directory/image.jpg",

            ]);
        }



    }

}
