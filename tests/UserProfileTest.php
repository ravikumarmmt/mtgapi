<?php

use App\User;
use App\UserProfile;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;

class UserProfileTest extends TestCase
{
    public function testUserProfileCreate(){
        $userprofile = UserProfile::create([ 
                                'user_id' => 2531,
                                'gender' => 'M',
                                'birthday' => '1990-12-12',
                                'height'=>  171,
                                'weight'=>  76,
                                'activity_level'=> 5,
                                'exercise_days'=>  3,
                            ]);
         $this->seeInDatabase('users_profile', ['user_id' => 2531]);
    }     
    public function testUserProfileDelete(){
        $user_found = UserProfile::where('user_id', 2531);
        $user_found->delete();
        $this->notSeeInDatabase('users_profile', ['user_id' => 2531]);
    }   
    
    public function testToGetUserProfile(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/getprofile', ['user_id' => $user_id, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        //$this->assertEquals($data['data']['name'], 'The name field is required.');
    }
    
    public function testUserProfileGenderField(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/saveprofile', ['picture' => 'profile.jpg', 'gender' => '', 'birthday' => '1990-12-12', 'height' => 171,
                                'weight' => 76, 'activity_level' => 5, 'exercise_days' => 3, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['gender'], 'The gender field is required.');
    }    
    public function testUserProfileBirthdayField(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/saveprofile', ['picture' => 'profile.jpg', 'gender' => 'M', 'birthday' => '', 'height' => 171,
                                'weight' => 76, 'activity_level' => 5, 'exercise_days' => 3, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['birthday'], 'The birthday field is required.');
    }
    public function testUserProfileHeightField(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/saveprofile', ['picture' => 'profile.jpg', 'gender' => 'M', 'birthday' => '1990-12-12', 'height' =>'',
                                'weight' => 76, 'activity_level' => 5, 'exercise_days' => 3, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);        
        $this->assertEquals($data['data']['height'], 'The height field is required.');
    }
    public function testUserProfileWeightField(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/saveprofile', ['picture' => 'profile.jpg', 'gender' => 'M', 'birthday' => '1990-12-12', 'height' =>171,
                                'weight' => '', 'activity_level' => 5, 'exercise_days' => 3, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);        
        $this->assertEquals($data['data']['weight'], 'The weight field is required.');
    }
    public function testUserProfileActivityLevelField(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/saveprofile', ['picture' => 'profile.jpg', 'gender' => 'M', 'birthday' => '1990-12-12', 'height' =>171,
                                'weight' => 76, 'activity_level' => '', 'exercise_days' => 3, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);        
        $this->assertEquals($data['data']['activity_level'], 'The activity level field is required.');
    }  
    public function testUserProfileExerciseDaysField(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/saveprofile', ['picture' => 'profile.jpg', 'gender' => 'M', 'birthday' => '1990-12-12', 'height' =>171,
                                'weight' => 76, 'activity_level' => 5, 'exercise_days' => '', 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);        
        $this->assertEquals($data['data']['exercise_days'], 'The exercise days field is required.');
    }      

}