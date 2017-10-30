<?php

use Illuminate\Database\Seeder;

class SpecialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('specials')->insert([ 'name' => 'general']);
      DB::table('specials')->insert([ 'name' => 'orthopedic']);
      DB::table('specials')->insert([ 'name' => 'urology']);
      DB::table('specials')->insert([ 'name' => 'neuro']);
      DB::table('specials')->insert([ 'name' => 'cardiothoracic']);
      DB::table('specials')->insert([ 'name' => 'aural']);
      DB::table('specials')->insert([ 'name' => 'oculist']);
    }
}
