<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borganizer extends Model
{
    //
    protected $table = "b_organized";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
