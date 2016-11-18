<?php
use Illuminate\Database\Seeder;

//use Database\seeds\GoalsTableSeeder;
//use Database\seeds\CurrentActivityLevelTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call('GoalsTableSeeder::class');
        $this->call('CurrentActivityLevelTableSeeder');
    }
}
