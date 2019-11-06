<?php

use App\OtherTool;
use Illuminate\Database\Seeder;

class OtherToolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $otherTools = [
            ['name' => 'git'],
            ['name' => 'circleci'],
            ['name' => 'android'],
            ['name' => 'aws-cli'],
            ['name' => 'pipenv'],
            ['name' => 'dropbox-paper'],
            ['name' => 'bash'],
            ['name' => 'amazon-glacier'],
            ['name' => 'webpack'],
            ['name' => 'aws'],
            ['name' => 'bigquery'],
            ['name' => 'azure'],
            ['name' => 'docker'],
        ];

        foreach ($otherTools as $key => $otherTool) {
            OtherTool::create([
                'name' => $otherTool['name'],
            ]);
        }
    }
}
