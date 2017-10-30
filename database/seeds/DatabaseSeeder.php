<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitiesSeeder::class);
        $this->call(SpecialsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BuildCategoriesSeeder::class);
        $this->call(BuildSeeder::class);
    }
}
