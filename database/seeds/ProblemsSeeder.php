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
        $users = \App\Entities\User::all();
        $ids=array();

        foreach ($users as $user) {
            array_push($ids,$user->id);
        }


        for($i=0;$i<count($users);$i++)
        {

            Problem::create([
                'title'=>$faker->catchPhrase,
                'author'=>$faker->name,
                'institution'=> $faker->company,
                'description'=> $faker->text,
                'numSolutions' =>$faker ->numberBetween(0,100),
                'limitTime'=> $faker ->numberBetween(0,10),
                'limitMemory' => 10.0,
                'numWarnings' => 0,
                'state' => $faker->randomElement(['active','suspended','blocked','deleted']),
                'problemLink'=> 'SERVER\url\data\problem\id' .$faker->numberBetween(0,1000000), //  SERVER\url\data\problem\id1244356

                'user_id' => $faker->randomElement($ids),

            ]);
        }



    }


}