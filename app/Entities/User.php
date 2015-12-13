<?php namespace SolutionBook\Entities;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;


/**
 * Class User
 * @package SolutionBook\Entities
 */
class User extends Entity implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email','confirmed','confirmation_code','password','rol','ranking','avatar','state','numWarnings','institution','userProblem_id','remember_token'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    /**
     * Regresa las notitificaciones que tiene el usuario
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::getClass());
    }

    /**
     * Regresa las noticias que tiene este usuario
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notices()
    {
        return $this->hasMany(Notice::getClass());
    }

    public function solutions()
    {
        return $this->hasMany(Solution::getClass());
    }
    public function problems()
    {
        return $this->hasMany(Problem::getClass());
    }



    /**
     * Esta es la relacion de muchos a muchos likes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany SolutionUser
     */
    public function likes()
    {
        return $this->belongsToMany(Solution::getClass());
    }

    /**
     * Mis usuarios que promovi como ProbleSetter
     * @return Users
     */
    public function usersPromoted($rol,$cadena=null)
    {
        if($cadena!=null){
            $sql="case when username LIKE '$cadena' then 0 when username LIKE '$cadena%' then 1 when username LIKE '%$cadena%' then 2 when username LIKE '%$cadena' then 3 else 4 end, username";
            if($rol=='super')
                $result= DB::table('users')->where('userProblem_id','!=','null')->where('username','LIKE','%'.$cadena.'%')->orderBy(DB::raw($sql), 'ASC')->paginate(9);
            else
                $result= DB::table('users')->where('userProblem_id',$this->id)->where('username','LIKE','%'.$cadena.'%')->orderBy(DB::raw($sql), 'ASC')->paginate(9);
            return $result;
        }
        if($rol!='super')
            return User::where('userProblem_id','=',$this->id)->paginate(9);
        else
            return User::where('userProblem_id','!=','null')->paginate(9);
    }

    /**
     * Regresa el problem setter que me promovio
     * @return User
     */
    public function promoter()
    {
        return $this->belongsTo(User::getClass());
    }

    public function liked()
    {
        return $this->belongsToMany(Solution::getClass(),'solution_user');
    }

    public function hasLiked($idSolution)
    {
        return $this->liked()->where('solution_id',$idSolution)->count();
    }

    /**
     * @param Solution  $solution->id
     * @return bool
     */
    public function like($idSolution)
    {
        if($this->hasLiked($idSolution)) return false;

        $this->liked()->attach($idSolution);
        return true;
    }

    public function disLike($idSolution)
    {
        if(!$this->hasLiked($idSolution)) return false;
        $this->liked()->detach($idSolution);
        return true;
    }
    /**
     * @return mixed
     */
    public function mySolutions()
    {
        $previewSolutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->join('problems','problems.id','=','solutions.problem_id')
            ->select('users.id as userId','users.username','solutions.id','solutions.explanation', 'solutions.numLikes',
                'solutions.dislikes','solutions.state','code_solutions.limitTime','code_solutions.limitMemory',
                'code_solutions.language','problems.title','problems.id as idProblem')
            ->where('users.id',$this->id)
            ->paginate(10);

        return $previewSolutions;
    }
    public static function searchUsername()
    {
        $usernames = DB::table('users')
            ->select('username')
            ->get();

        return $usernames;



    }
    public static function systemUsers()
    {
        $users = DB::table('users')
            ->where('users.rol','!=','super')
            ->orderBy('users.username')
            ->paginate(15);
//->get();

       // dd($users);
        return $users;



    }

    /**
     * @return topUsers
     */
    public static function topUsers(){
        return User::where('state','active')->orderBy('ranking', 'desc')->where('rol','<>','super')->take(10)->get();
    }

    /**
     * @param $language
     * @return array
     */
    public function mySolutionsPerLanguageAnually($language){
        $languageArray = array(0,0,0,0,0,0,0,0,0,0,0,0);
//        dd($languageArray);
        $solutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->select('code_solutions.language','code_solutions.created_at')
            ->where('users.id',$this->id)
            ->where('code_solutions.language',$language)->get();

        foreach ($solutions as $solution)
        {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $solution->created_at);
            $languageArray[$date->month-1]+=1;
        }
        return $languageArray;

    }
    /**
     * Mis usuarios para promover como ProbleSetter
     * @return Users
     */
    public static function usersSolver($cadena=null)
    {
        if($cadena!=null){
            $sql="case when username LIKE '$cadena' then 0 when username LIKE '$cadena%' then 1 when username LIKE '%$cadena%' then 2 when username LIKE '%$cadena' then 3 else 4 end, username";
            $result= DB::table('users')->where('rol','solver')->where('username','LIKE','%'.$cadena.'%')->orderBy(DB::raw($sql), 'ASC')->paginate(9);
            return $result;
        }
        return User::where('rol','=','solver')->paginate(9);
    }




}
