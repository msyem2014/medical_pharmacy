<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'osama mohamed',
                    'special_id' => 1,
                    'email' => 'xgen.osama@gmail.com',
                    'password' => bcrypt('123456'),
                    'role' => 1,
                    'image' => 'default.png',
                    'birth_date' => \Carbon\Carbon::now(),
                    //'created_at' => '2017-01-24 00:00:00',
                    //'updated_at' => '2017-01-16 00:00:00',
                ),
        ));
    }
}
