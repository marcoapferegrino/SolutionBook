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
		'SolutionBook\Console\Commands\Inspire',

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
        $schedule->call(function () {    /// borrar warnings expirados con mas de 7 dias


            $limit= Carbon::now()->subDays(7)->toDateString();
            $warnings=Warning::where('warnings.created_at','<',$limit)->where('warnings.state','=','expired')->get();
            //$warnings=Warning::all()
            //       ->where('warnings.created_at','>',$limit);

            foreach($warnings as $warning){
                $warning->delete();

            }
            /*
            $warnings=Warning::all();
            foreach($warnings as $warning){
                $warning->state='forAdmin';
                $warning->save();

            }*/
        })->daily()->at('23:00');
        $schedule->call(function () {   // se acabo el tiempo limite para un warning 14 dias



            $limit= Carbon::now()->subDays(14)->toDateString();
            $warnings=Warning::where('warnings.created_at','<',$limit)->where('warnings.state','=','process')->get();
            // dd($warnings);
            //$warnings=Warning::all()
            //       ->where('warnings.created_at','>',$limit);

            foreach($warnings as $warning){
                $warning->state='forAdmin';
                $warning->save();

            }
            /*
            $warnings=Warning::all();
            foreach($warnings as $warning){
                $warning->state='forAdmin';
                $warning->save();

            }*/
        })->everyMinute();//->daily();
	}


}
