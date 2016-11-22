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

    public function testUserNameIsRequired(){
        $response = $this->call('POST', '/register', ['name' => '', 'email' => 'mtgtest@gmail.com', 'password' => 'test123']);
        $data = json_decode($response->getContent(), true);
		print_r($data);die;
		
        $this->assertEquals($data['data']['name'], 'The name field is required.');
    }
	
}

