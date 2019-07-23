<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AContent extends Model
{
    //
    protected $table = 'a_content';

    public function a()
    {
        return $this->belongsTo('app\AContent');
    }

}
