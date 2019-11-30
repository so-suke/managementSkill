<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrameworkExperience extends Model
{
    protected $fillable = [
        'employee_id', 'framework_id', 'experience_period_id',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function framework()
    {
        return $this->belongsTo('App\Framework');
    }

    public function experiencePeriod()
    {
        return $this->belongsTo('App\ExperiencePeriod');
    }
}
