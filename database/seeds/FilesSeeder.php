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

            $name =$faker->word;
            $id =0;
            if($i%2){
                $id=$faker->randomElement($idsSolutions);
                Files::create([
                    'name'=> $name.$faker->randomElement(['.jpg','.png','.pdf','.mp3','.txt']),
                    'path'=>'solution/'.$id.'solution',
                    'description'=> $faker->text,
                    'type' =>$faker->randomElement(['imagenEjemplo','imagenApoyo','notaVoz','fileinput','fileOutput']),


                    'solution_id'=> $id,

                ]);
            }
            else
            {
                $id=$faker->randomElement($idsProblems);
                Files::create([
                    'name'=> $name.$faker->randomElement(['.jpg','.png','.pdf','.mp3','.txt']),
                    'path'=>'problema/'.$id.'problema',
                    'description'=> $faker->text,
                    'type' =>$faker->randomElement(['imagenEjemplo','imagenApoyo','notaVoz','fileinput','fileOutput']),

                    'problem_id'=> $id,


                ]);
            }

        }



    }


}