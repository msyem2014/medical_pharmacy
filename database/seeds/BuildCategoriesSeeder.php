<?php

use Illuminate\Database\Seeder;

class BuildCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('category_buildings')->insert([ 'name' => 'pharmacy']);
      DB::table('category_buildings')->insert([ 'name' => 'hospital']);
    }
}
