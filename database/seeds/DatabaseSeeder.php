<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
    public function run()
    {
        Model::unguard();

        $this->truncateTables(array(

            'users',
            'password_resets',
            'problems',
            'solutions',
            'code_solutions',
            'solution_user',
            'files',
            'links',
            'notices',
            'judges_lists',
            'tags'


        ));



        $this->call('UsersSeeder');

        $this->call('JudgesListSeeder');
<<<<<<< HEAD
=======
        //$this->call('TagsSeeder');
>>>>>>> d3a1c4d47d095c3ca3fc28172b55202e4f5d03dc
        $this->call('CodeSolutionSeeder');
        $this->call('ProblemsSeeder');

        $this->call('TagsSeeder');
        $this->call('SolutionsSeeder');
        $this->call('LikesSeeder');
        $this->call('FilesSeeder');
        $this->call('LinksSeeder');
        $this->call('NoticesSeeder');





        //  Model::reguard();
    }

    private function truncateTables(array $tables)
    {
        $this->checkForeignKeys(false);

        foreach($tables as $table)
        {
            DB::table($table)->truncate();
        }
        $this->checkForeignKeys(true);

    }

    private function checkForeignKeys($check)
    {
        $check = $check ? '1' : '0';
        DB::statement('SET FOREIGN_KEY_CHECKS ='.$check);
    }

}
