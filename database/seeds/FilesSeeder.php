<?php
/**
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\Files;
class FilesSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
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



        for($i=0;$i<count($solutions);$i++)
        {

            $name =$faker->catchPhrase;
            if($i%2){
                Files::create([
                    'name'=> $name.$faker->randomElement(['.jpg','.png','.pdf','.mp3','.txt']),
                    'path'=>'solution/'.$faker->numberBetween(1,12).'solution',
                    'description'=> $faker->text,
                    'type' =>$faker->randomElement(['imagenEjemplo','imagenApoyo','notaVoz','fileinput','fileOutput']),


                    'solution_id'=> $faker->randomElement($idsSolutions),

                ]);
            }
            else
            {
                Files::create([
                    'name'=> $name.$faker->randomElement(['.jpg','.png','.pdf','.mp3','.txt']),
                    'path'=>'problema/'.$faker->numberBetween(1,12).'problema',
                    'description'=> $faker->text,
                    'type' =>$faker->randomElement(['imagenEjemplo','imagenApoyo','notaVoz','fileinput','fileOutput']),

                    'problem_id'=> $faker->randomElement($idsProblems),


                ]);
            }

        }



    }


}