<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherToolExperience extends Model
{
    protected $fillable = [
        'employee_id', 'other_tool_id', 'experience_period_id',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function otherTool()
    {
        return $this->belongsTo('App\OtherTool');
    }

    public function experiencePeriod()
    {
        return $this->belongsTo('App\ExperiencePeriod');
    }
}
