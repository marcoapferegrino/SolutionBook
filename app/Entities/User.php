<?php namespace SolutionBook\Entities;

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
	protected $fillable = ['username', 'email', 'password','rol','ranking','avatar','state','numWarnings','institution','userProblem_id','remember_token'];

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
     * @return mixed
     */
    public function mySolutions()
    {
        $previewSolutions = DB::table('solutions')
            ->join('users','users.id','=','solutions.user_id')
            ->join('code_solutions','code_solutions.id','=','solutions.codeSolution_id')
            ->join('problems','problems.id','=','solutions.problem_id')
            ->select('users.id as userId','users.username','solutions.id','solutions.explanation', 'solutions.numLikes',
                'solutions.dislikes','solutions.ranking','solutions.state','code_solutions.limitTime','code_solutions.limitMemory',
                'code_solutions.language','problems.title','problems.id as idProblem')
            ->where('users.id',$this->id)
            ->orderBy('solutions.ranking','desc')
            ->paginate(10);

        return $previewSolutions;
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
    public function usersPromoted()
    {
        return $this->hasMany(User::getClass());
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

    public static function searchUsername()
    {
        $usernames = DB::table('users')
                    ->select('username')
                    ->get();

        return $usernames;



    }





}
