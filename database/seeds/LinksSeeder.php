<?php
/**
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use SolutionBook\Entities\Link;
class LinksSeeder extends Seeder {

    public function run()
    {
        $faker=Faker::create();
        $problems = \SolutionBook\Entities\Problem::all();
        $solutions = \SolutionBook\Entities\Solution::all();
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
                    'type' =>$faker->randomElement(['YouTube','Github','BitBucket','Facebook','Twitter','JuezOnline','Amonestación']),

                    'solution_id'=> $faker->randomElement($idsSolutions),
                ]);
            }
            else{
                Link::create([
                    'link' =>$faker->url,
                    'type' =>$faker->randomElement(['YouTube','Github','BitBucket','Facebook','Twitter','JuezOnline','Amonestación']),

                    'problem_id'=> $faker->randomElement($idsProblems),
                ]);
            }


        }
    }

}