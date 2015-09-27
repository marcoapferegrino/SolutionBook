<?php
/**
 * Created by PhpStorm.
 * User: luisknight
 * Date: 5/07/15
 * Time: 06:00 PM
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\Warning;
class WarningsSeeder extends Seeder {
    public function run()
    {
        $faker = Faker::create();

        for($i=0;$i<10;$i++)
        {

            Warning::create([

                'description'=> $faker->text(),
                'reason' =>$faker->randomElement(['copiedCode','notWorking'.'contentInapropiate']),
                'state' =>$faker->randomElement(['process','expired']),
                'hoursToAttend' =>$faker->numberBetween(2,5),
                'solution_id' =>1,
                'problem_id' =>1,
                'user_id'=>1,
                'link_id'=>1,

            ]);
        }



    }


}