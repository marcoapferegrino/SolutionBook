<?php namespace SolutionBook\Http\Controllers;
use Redirect;
use Socialize;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use SolutionBook\Entities\Tools;
use SolutionBook\Entities\User;
use Illuminate\Support\Facades\Session;
use SolutionBook\Http\Requests\AddUserRequest;

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
            return view('auth/termsAndConditions',compact('correo','avatar','nombre'));
        }
        if($userStore->state=='blocked')
        {
            return redirect()->action('WelcomeController@blockedByAdmin');
        }
        $this->auth->login($userStore, true);
        return redirect('/home');

    }

    public function termsConditions(Request $request){
        $nombre=$request->nombre;
        $correo=$request->correo;
        $avatar=$request->avatar;
        return view('auth/changeNameUser',compact('correo','avatar','nombre'));
    }
    public function changeNameUser(AddUserRequest $request){
        //dd($request);
        $avatar2=$request->avatarSocial;
        $password = bcrypt($request->password);

        // $file = Input::file('avatar');
        $image=$request->file('avatar');

        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=> $password,
            'rol'=> 'solver',
            'confirmed'=>1,
            'ranking' => 0,
            'state' => 'active',
            'numWarnings' => 0,
        ]);

        if($image!=null){
            $idUser = $user->id;
            $path ='users/'.$idUser.'/';
            $pathAvatar = $path.'avatar/';

            mkdir($pathAvatar,null, true);

            $nameImage = $image->getClientOriginalName();
            // dd($image,$pathAvatar,$nameImage);

            $image->move($pathAvatar,$nameImage);
            $renameImg= 'avatar.'.$image->getClientOriginalExtension();

            rename($pathAvatar.$nameImage,$pathAvatar.$renameImg );
            $user->avatar= $pathAvatar.$renameImg;
            $user->save();
        }
        else{
            $user->avatar= $avatar2;
            $user->save();
        }
        Tools::sendEmail($user->email,$user->username,"Te has registrado como Solver","addSolver");
        Session::flash('message', '¡Ya puedes iniciar sesión '.$user->username.'!');

        return Redirect::to('/auth/login');
    }



}