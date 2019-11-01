<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Employee', 10)->create();

        // DB::table('employees')->insert([
        //     [
        //         'name' => 'admin_e',
        //         'email' => 'admin_e@example.com',
        //         'password' => bcrypt('password'),
        //         'remember_token' => null,
        //         'created_at' => '2018-10-02 14:28:19',
        //         'updated_at' => '2018-10-02 14:28:19'
        //     ]
        // ]);

    }
}
