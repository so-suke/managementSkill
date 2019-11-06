<?php

use App\Employee;
use App\OtherTool;
use App\OtherToolExperience;
use Illuminate\Database\Seeder;

class OtherToolExperiencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $otherExperiences = [];
        $employees = Employee::orderBy('id')->get('id');
        $others = OtherTool::orderBy('id')->get('id');
        foreach ($employees as $key => $employee) {
            $othersSliced = $others->shuffle()->slice(0, rand(1, 3));
            foreach ($othersSliced as $key => $other) {
                $otherExperiences[] = ['employee_id' => $employee->id, 'other_tool_id' => $other->id, 'experience_period_id' => rand(1, 5)];
            }
        }

        foreach ($otherExperiences as $key => $otherExperience) {
            OtherToolExperience::create([
                'employee_id' => $otherExperience['employee_id'],
                'other_tool_id' => $otherExperience['other_tool_id'],
                'experience_period_id' => $otherExperience['experience_period_id']
            ]);
        }
    }
}
