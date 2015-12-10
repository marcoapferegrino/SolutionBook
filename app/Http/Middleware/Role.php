<?php

namespace SolutionBook\Http\Middleware;

use Closure;

class Role {
    protected $hierarchy = [
        'super'	        => 60,
        'problem' 		=> 50,
        'solver'		=> 40

    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();
        /*
         * Si el usuario logueado tiene un rol menor al que necesita la ruta entonces ruta no encontrada
         * */
        if($this->hierarchy[$user->rol] < $this->hierarchy[$role]) {
//            abort(404);
            return view('errors.404');
        }
        return $next($request);
    }


}