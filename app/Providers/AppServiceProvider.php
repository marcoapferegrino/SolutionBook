<?php namespace SolutionBook\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Validator::extend('languajeWithFileExtension', function($field,$value,$parameters){
			$extensionFile = $value->getClientOriginalExtension();
			$languaje = $parameters[0];
			//dd($parameters,$value->getClientOriginalExtension());
//			dd($extensionFile);
			$state = false;
			switch($languaje)
			{
				case 'c':
					if($extensionFile == 'c')
						$state=true;
					break;
				case 'c++':
					if($extensionFile == 'cpp')
						$state=true;
					break;
				case 'java':
					if($extensionFile == 'java')
						$state=true;
					break;
				case 'python':
					if($extensionFile == 'py')
						$state=true;
					break;
				default:
					return $state;

			}

			return $state;
		});
		Validator::extend('extension', function($field,$value,$parameters){
			$extensionFile = $value->getClientOriginalExtension();
			//dd($extensionFile,$parameters);
			$state = false;
			foreach ($parameters as $param)
			{
				if ($param == $extensionFile)
				{
					$state = true;
					break;
				}
			}
			return $state;

		});

        Validator::extend('oneword', function($field, $value)
        {
           // $resolution =  preg_match('/^[\pL\s]+$/u', $value);
            $resolution =  preg_match('/^[ 0-9a-zA-ZÑñ]+$/u', $value);
            if($resolution!=true){

                return $resolution;

            }
            if (strpos($value," ") !== false){
            return false;
            }
            else
            {
            return true;

            }
        });

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'SolutionBook\Services\Registrar'
		);
	}

}
