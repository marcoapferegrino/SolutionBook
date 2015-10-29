<?php namespace SolutionBook\Http\Controllers;
use Redirect;
use Socialize;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use SolutionBook\Entities\User;

class AccountController extends Controller {
    // To redirect facebook

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function github_redirect($provider=null) {
        return Socialize::with($provider)->redirect();
    }
    // to get authenticate user data
    public function github($provider=null) {
        $user = Socialize::with($provider)->user();
        // Do your stuff with user data.
        $userStore= User::where('email','=', $user->getEmail())->first();
        if($user->getName()=='')
            $nombre = $user->getNickname();
        else
            $nombre = $user->getName();

        $correo = $user->getEmail();
        $avatar = $user->getAvatar();
       // echo $nombre.$correo.$avatar;
        if(!$userStore){

            /*$userStore = User::create([
                'username'=>$nombre,
                'email'=>$correo,
                'password'=> '',
                'rol'=> 'solver',
                'ranking' => 0,
                'avatar'=>$avatar,
                'state' => 'active',
                'numWarnings' => 0,
            ]);*/
            return view('auth/terminosCondiciones',compact('correo','avatar','nombre'));
        }
        $userStore->username= $nombre;
        $userStore->avatar= $avatar;
        $userStore->save();
        $this->auth->login($userStore, true);
        return redirect('/home');

    }
    public function termsConditions(Request $request){
        $nombre=$request->nombre;
        $correo=$request->correo;
        $avatar=$request->avatar;
        $userStore = User::create([
            'username'=>$nombre,
            'email'=>$correo,
            'password'=> '',
            'rol'=> 'solver',
            'ranking' => 0,
            'avatar'=>$avatar,
            'state' => 'active',
            'numWarnings' => 0,
        ]);
        $this->auth->login($userStore, true);
        return redirect('/home');
    }

}