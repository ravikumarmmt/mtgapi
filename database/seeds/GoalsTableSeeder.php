<?php
use App\Goals;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GoalsTableSeeder extends Seeder
{
    public function run()
    {
        //Goals::create(['name' =>]);  
        DB::table('goals')->insert([['name' => 'Weight Los'],['name' => 'Weight Gain'], ['name' => 'Weight Maintenance'], ['name' => 'Weight Loss*']]);
    }
} 
