<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 28/06/15
 * Time: 9:33
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use SolutionBook\Entities\Like;
use \SolutionBook\Entities\User;
use \SolutionBook\Entities\Solution;


class LikesSeeder extends Seeder {

    public function run(){

        $users = User::all();
        $solutions = Solution::all();

        foreach($users as $user)
        {
            $num=rand(1,count($solutions));
            $solution = Solution::find($num);
            $solution2 = Solution::find(1);
            $user->likes()->save($solution);
            $user->likes()->save($solution2);

        }
    }
}