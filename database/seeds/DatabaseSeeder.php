<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            JobTitlesTableSeeder::class,
            EmployeesTableSeeder::class,
            LanguagesTableSeeder::class,
            FrameworksTableSeeder::class,
            OtherToolsTableSeeder::class,
            ExperiencePeriodsTableSeeder::class,
            LanguageExperiencesTableSeeder::class,
            FrameworkExperiencesTableSeeder::class,
            OtherToolExperiencesTableSeeder::class,
        ]);
    }
}
