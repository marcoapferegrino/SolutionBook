<?php
/**
 * Created by PhpStorm.
 * User: luisknight
 * Date: 26/06/15
 * Time: 12:00 AM
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\Problem;
class ProblemsSeeder extends Seeder {


    /**
     *
     */
    public function run()
    {
        $faker = Faker::create();


        for($i=0;$i<10;$i++)
        {

            $problem= Problem::create([
                'title'=>$faker->catchPhrase,
                'author'=>$faker->name,
                'institution'=> $faker->company,
                'description'=> $faker->text,
                'numSoluions' =>$faker ->numberBetween(0,100),
                'limitTime'=> $faker ->numberBetween(0,10),
                'limitMemory' => 10.0,
                'numWarnings' => 0,
                'state' => $faker->randomElement(['Active','Suspended','Blocked','Deleted']),
                'problemLink'=> 'SERVER\url\data\problem\id' .  $faker->unique() ->numberBetween(0,1000000),
                                //  SERVER\url\data\problem\id1244356
            ]);
        }



    }


}