<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 25/06/15
 * Time: 10:43
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use App\Entities\User;


class UsersSeeder extends Seeder{



    public function run()
    {
        $num_users = 10;
        $faker = Faker::create();

        User::create([
            'username'=>'marco',
            'email'=>'ferefuc@gmail.com',
            'password'=> bcrypt('secret'),
            'rol'=> 'super',
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