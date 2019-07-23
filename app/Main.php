<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{

    protected $table = 'main_page';
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'id',
            'title',
            'description',
            'created_at',
            'updated_at',
        ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Image')->orderBy('created_at');
    }
}