<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 25/06/15
 * Time: 11:17
 */
use \Illuminate\Database\Seeder;
use \App\Entities\Solution;
use Faker\Factory as Faker;
class SolutionsSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $problems = \App\Entities\Problem::all();
        $codeSolutions = \App\Entities\CodeSolution::all();
        $users = \App\Entities\User::all();

        $idsUsers=array();
        $idsProblems=array();
        $idsCodeSol=array();




        foreach ($users as $user) {
            array_push($idsUsers,$user->id);
        }

        foreach ($problems as $problem) {
            array_push($idsProblems,$problem->id);
        }
        foreach ($codeSolutions as $codeSol) {
            array_push($idsCodeSol,$codeSol->id);
        }



        for($i=0 ; $i<count($users);$i++)
        {
             Solution::create([
                'explanation' => $faker->realText(500, $indexSize = 2),
                'state' => $faker->randomElement(['active','suspended','blocked','deleted']),
                'ranking' => $faker->numberBetween(1,100),
                'solutionLink' => '/solutions/idSolution',
                'numWarnings'=>0 ,
                'numLikes' => $faker->numberBetween(0,1000),
                'dislikes'=> $faker->numberBetween(0,500),


                'problem_id'=> $faker->randomElement($idsProblems),
                'user_id'=> $faker->randomElement($idsUsers),
                'codeSolution_id'=> $faker->randomElement($idsCodeSol),


            ]);
        }
    }
}