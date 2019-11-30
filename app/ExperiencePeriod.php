<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperiencePeriod extends Model
{
    /**
     * 配列中に含める属性
     *
     * @var array
     */
    protected $visible = ['id', 'name'];
}
