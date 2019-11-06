<?php

use App\Framework;
use Illuminate\Database\Seeder;

class FrameworksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frameworks = [
            ['name' => 'Laravel'],
            ['name' => 'CakePHP'],
            ['name' => 'FuelPHP'],
            ['name' => 'ZendFramework'],
            ['name' => 'RubyonRails'],
            ['name' => 'SpringBoot'],
            ['name' => 'Struts'],
            ['name' => 'Seasar2'],
            ['name' => 'Angluar'],
            ['name' => 'React'],
            ['name' => 'Vue.js'],
        ];

        foreach ($frameworks as $key => $framework) {
            Framework::create([
                'name' => $framework['name'],
            ]);
        }
    }
}
