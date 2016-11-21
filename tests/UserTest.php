<?php

use App\User;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;

class UserTest extends TestCase
{

    public function testGetUsers(){
        $response = $this->call('GET', '/users');
        $this->assertEquals(200, $response->status());
    }

   
    
}

