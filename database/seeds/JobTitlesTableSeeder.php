<?php

use App\JobTitle;
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobTitles = [
            ['name' => 'フロントエンドエンジニア'],
            ['name' => 'サーバーサイドエンジニア'],
        ];

        foreach ($jobTitles as $key => $jobTitle) {
            JobTitle::create([
                'name' => $jobTitle['name'],
            ]);
        }
    }
}
