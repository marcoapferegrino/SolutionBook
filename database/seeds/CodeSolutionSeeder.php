<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 26/06/15
 * Time: 11:10
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\CodeSolution;
class CodeSolutionSeeder extends Seeder {

    public function run()
    {
        $faker=Faker::create();

        for($i=1;$i<10;$i++)
        {

            CodeSolution::create([
                    'path' => 'solution/'.$faker->numberBetween(1,12).'solution',
                    'language' =>$faker->randomElement(['c','c++','java','python']),
                    'limitTime' => $faker->numberBetween(1,10),
                    'limitMemory' => $faker->numberBetween(1,5),
            ]);


        }
    }

}