<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aorganizer extends Model
{
    //
    protected $table = "a_organized";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
