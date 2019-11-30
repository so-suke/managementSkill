<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageExperience extends Model
{
    protected $fillable = [
        'employee_id', 'language_id', 'experience_period_id',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function experiencePeriod()
    {
        return $this->belongsTo('App\ExperiencePeriod');
    }
}
