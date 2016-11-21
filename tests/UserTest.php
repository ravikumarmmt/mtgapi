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
    public function testUserCreate(){
        $api_token = str_random(60);
        $results = DB::select(DB::raw('SELECT NOW() AS end_time'));
        $user = User::create([  'name' => 'unittest',
                                'email' => 'unittest@test.com',
                                'password'=>  Crypt::encrypt('test@123'),
                                'api_token' => $api_token,
                                'expire_at' => $results[0]->end_time
                            ]);
         $this->seeInDatabase('users', ['email' => 'unittest@test.com']);
    } 
     public function testUserDelete(){
        $user_found = User::where('email', 'unittest@test.com');
        $user_found->delete();
        $this->notSeeInDatabase('users', ['email' => 'unittest@test.com']);
    }
    public function testUserNameIsRequired(){
        $response = $this->call('POST', '/register', ['name' => '', 'email' => 'mtgtest@gmail.com', 'password' => 'test123']);
        $data = json_decode($response->getContent(), true);
		echo "<pre>";print_r($data);die;
        $this->assertEquals($data['data']['name'], 'The name field is required.');
    }
    public function testUserEmailIsRequired(){
        $response = $this->call('POST', '/register', ['name' => 'mtgtest', 'email' => '', 'password' => 'test123']);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['email'], 'The email field is required.');
    }
    public function testUserPasswordIsRequired(){
        $response = $this->call('POST', '/register', ['name' => 'mtgtest', 'email' => 'mtgtest@gmail.com', 'password' => '']);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['password'], 'The password field is required.');
    }   
    
}

