<?php
/**
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\Link;
class LinksSeeder extends Seeder {

    public function run()
    {
        $faker=Faker::create();
        $problems = \App\Entities\Problem::all();
        $solutions = \App\Entities\Solution::all();
        $idsSolutions=array();
        $idsProblems=array();

        foreach ($solutions as $sol) {
            array_push($idsSolutions,$sol->id);
        }

        foreach ($problems as $problem) {
            array_push($idsProblems,$problem->id);
        }

        for($i=1;$i<10;$i++)
        {
            if($i%2)
            {
                Link::create([
                    'link' =>$faker->url,
                    'type' =>$faker->randomElement(['youTube','Github','Facebook','Twitter','juezOnline','amonestacion']),

                    'solution_id'=> $faker->randomElement($idsSolutions),
                ]);
            }
            else{
                Link::create([
                    'link' =>$faker->url,
                    'type' =>$faker->randomElement(['youTube','Github','Facebook','Twitter','juezOnline','amonestacion']),

                    'problem_id'=> $faker->randomElement($idsProblems),
                ]);
            }


        }
    }

}