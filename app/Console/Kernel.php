<?php namespace SolutionBook\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SolutionBook\Entities\Link;
use SolutionBook\Entities\Notification;
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

            foreach($warnings as $warning){
                $link=Link::find($warning->link_id);
                $link->delete();
                $warning->delete();
            }

        })->daily()->at('00:41');
        $schedule->call(function () {   // se acabo el tiempo limite para un warning 14 dias

            $limit= Carbon::now()->subDays(14)->toDateString();
            $warnings=Warning::where('warnings.created_at','<',$limit)->where('warnings.state','=','process')->get();

            foreach($warnings as $warning){
                $warning->state='forAdmin';
                $warning->save();
            }

        })->daily()->at('00:10');

        $schedule->call(function () {   // se borran notificaciones con mas de 30 dias de antiguedad y han sido vistas

            $limit= Carbon::now()->subDays(30)->toDateString();//
            $notifications=Notification::where('notifications.created_at','<',$limit)->where('notifications.viewed','=','1')->get();

            foreach($notifications as $notification){
                $notification->delete();
            }

        })->daily();
	}





}
