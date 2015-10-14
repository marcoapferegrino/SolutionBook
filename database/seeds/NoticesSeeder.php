<?php
/**
 *
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use SolutionBook\Entities\Notice;
class NoticesSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        $users = \SolutionBook\Entities\User::all();
        $ids=array();

        foreach ($users as $user) {
            array_push($ids,$user->id);
        }


        for($i=0;$i<10;$i++)
        {

            Notice::create([
                'title'=>$faker->catchPhrase,
                'description'=> $faker->text,
                'finishDate' =>$faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years'),

                'user_id' => $faker->randomElement($ids),

            ]);
        }



    }


}