<?php namespace SolutionBook\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SolutionBook\Entities\Warning;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'SolutionBook\Console\Commands\Inspire'/*,
		'SolutionBook\Console\Commands\TestCommand'*/
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		/*$schedule->command('inspire')
				 ->hourly();*/
        $schedule->call(function () {

            $today= Carbon::now()->subDays(14)->toDateString();
            /*$warnings=DB::table('warnings')
                ->select('*')
               // ->where('warnings.created_at','<',$today)
                ->get();
            foreach($warnings as $warning){
                $warning->state='forAdmin';
                $warning->save();

            }*/
            $warnings=Warning::all();
            foreach($warnings as $warning){
                $warning->state='forAdmin';
                $warning->save();

            }
        })->everyMinute();//->daily();
	}

}
