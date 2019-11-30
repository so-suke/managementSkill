<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    protected $visible = ['id', 'name'];

    public function employees()
    {
        // return $this->belongsToMany('App\Employee');
        return $this->hasMany('App\Employee');
    }
}
