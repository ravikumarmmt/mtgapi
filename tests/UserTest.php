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
    
    public function testUserLogin(){
        $name = 'ravi';
        $email = 'ravik@enqos.com';
        $password = 'test@123';
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        //$this->assertEquals(200, $response->getStatusCode());
		echo "Testing";
        $data = json_decode($response->getContent(), true);
        print_r($data);die;
        $this->assertEquals($data['data']['name'], $name);
        $this->assertEquals($data['data']['email'], $email);
        
    }   
  
    
}

