<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class A extends Model
{
    //
    protected $table = 'a';

    public function content()
    {
        return $this->hasMany('app\AContent');
    }
}
