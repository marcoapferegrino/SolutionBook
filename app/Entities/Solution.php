<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities;
class Solution extends Entity {


    /**
     * Esta es la relacion de muchos a muchos de los Likes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likesDeUsuarios()
    {
        return $this->belongsToMany(User::getClass());
    }

}
