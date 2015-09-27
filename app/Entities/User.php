<?php namespace App\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


/**
 * Class User
 * @package App\Entities
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
	protected $fillable = ['name', 'email', 'password'];

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
        $this->liked()->detach($idSolution);
    }






}
