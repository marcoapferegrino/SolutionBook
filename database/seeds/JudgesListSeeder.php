<?php
/**
 * Created by PhpStorm.
 * User: luisknight
 * Date: 5/07/15
 * Time: 06:28 PM
 */
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;
use SolutionBook\Entities\JudgesList;
class JudgesListSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();


            JudgesList::create([

                'name'=> 'Caribbean Online Judge',
                'addressWeb' =>'http://coj.uci.cu/index.xhtml?',
                'facebook' =>'https://www.facebook.com/caribbeanonlinejudge/',
                'image' =>'judges/1/coj.png',

            ]);
        JudgesList::create([

            'name'=> 'UVa Online Judge',
            'addressWeb' =>'https://uva.onlinejudge.org/',
            'facebook' =>'https://www.facebook.com/UVaOnlineJudge/',
            'twitter' =>'https://twitter.com/uvaonlinejudge',
            'image' =>'judges/2/uva.png',

        ]);
        JudgesList::create([

            'name'=> 'Sphere Online Judge',
            'addressWeb' =>'http://www.spoj.com/',
            'facebook' =>'https://www.facebook.com/SPOJ-248106793203/info?ta...',
            'twitter' =>'https://twitter.com/spoj',
            'image' =>'judges/3/spoj.jpeg',

        ]);
        JudgesList::create([

            'name'=> 'omegaUp',
            'addressWeb' =>'https://omegaup.com/',
            'facebook' =>'https://www.facebook.com/omegaup',
            'twitter' =>'https://twitter.com/omegaup',
            'image' =>'judges/4/omegaup.png',

        ]);
        JudgesList::create([

            'name'=> 'URI Online Judge',
            'addressWeb' =>'https://www.urionlinejudge.com.br/judge/login',
            'facebook' =>'https://www.facebook.com/urionlinejudge/',
            'twitter' =>'https://twitter.com/urionlinejudge',
            'image' =>'judges/5/uri.png',

        ]);
        JudgesList::create([

            'name'=> 'The ACM-ICPC International Collegiate Program',
            'addressWeb' =>'https://icpc.baylor.edu/',
            'facebook' =>'https://www.facebook.com/ICPCNews/',
            'twitter' =>'https://twitter.com/icpcnews',
            'image' =>'judges/6/acmicpc.jpg',

        ]);




    }

}
