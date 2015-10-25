<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 25/06/15
 * Time: 10:43
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use SolutionBook\Entities\User;


class UsersSeeder extends Seeder{



    public function run()
    {
        $num_users = 10;
        $faker = Faker::create();

        User::create([
            'username'=>'marcoProblemS',
            'email'=>'ferefuc@gmail.com',
            'password'=> bcrypt('secret'),
            'rol'=> 'problem',
            'ranking' => $faker->randomNumber(),
            'avatar'=> 'marco'.'/avatar.jpg',
            'state' => 'active',
            'numWarnings' => 0,
        ]);
        User::create([
            'username'=>'marcoSolver',
            'email'=>'ferefuc@hotmail.com',
            'password'=> bcrypt('secret'),
            'rol'=> 'solver',
            'ranking' => $faker->randomNumber(),
            'avatar'=> 'marco'.'/avatar.jpg',
            'state' => 'active',
            'numWarnings' => 0,
        ]);

        for($i=1;$i<$num_users;$i++)
        {
            $username =$faker->unique()->userName;

            User::create([
                'username'=>$username,
                'email'=>$faker->unique()->email,
                'password'=> bcrypt('secret'),
                'rol'=> $faker->randomElement(['problem','solver']),
                'ranking' => $faker->numberBetween(1,100),
                'avatar'=> $username.'/avatar.jpg',
                'state' => 'active',
                'numWarnings' => 0,
            ]);
        }




    }
}