<?php
use App\CurrentActivityLevel;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CurrentActivityLevelTableSeeder extends Seeder
{
    public function run()
    {
        //Goals::create(['name' =>]);  
        DB::table('current_activity_level')->insert([['name' => '1 - couch potato'],['name' => '1 - couch carrot'], ['name' => '1 - couch cabbage'], ['name' => '1 - couch cucumber']]);
    }
} 
