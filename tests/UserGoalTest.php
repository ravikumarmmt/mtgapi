<?php

use App\User;
use App\UserProfile;
use App\UserGoal;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;

class UserGoalTest extends TestCase
{
//    public function testUserGoalCreate(){
//        $userprofile = UserGoal::create([ 
//                                'id'=> 3,
//                                'user_id' => 2,
//                                'goals_id' => 2,
//                                'goal_weight' => 75,
//                                'weight_preferred_pace_id'=>  1,
//                                'dietary_requirements_id'=>  3,
//                            ]);
//         $this->seeInDatabase('users_goal', ['user_id' => 2]);
//    }
//    
//    public function testUserGoalDelete(){
//        $user_found = UserGoal::where('id', 3);
//        $user_found->delete();
//        $this->notSeeInDatabase('users_goal', ['id' => 3]);
//    }
    public function testUserGoalIdRequired(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/savegoal', ['user_id' => 2, 'goals_id' => '', 'goal_weight' => 134, 'weight_preferred_pace_id' => 3,
                                'dietary_requirements_id' => 2, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['goals_id'], 'The goals id field is required.');
    }
    
    public function testUserGoalWeightRequired(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/savegoal', ['user_id' => 2, 'goals_id' => 1, 'goal_weight' => '', 'weight_preferred_pace_id' => 3,
                                'dietary_requirements_id' => 2, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['goal_weight'], 'The goal weight field is required.');
    }
    
    public function testUserWeightPreferredPaceRequired(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/savegoal', ['user_id' => 2, 'goals_id' => 1, 'goal_weight' => 134, 'weight_preferred_pace_id' => '',
                                'dietary_requirements_id' => 2, 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['weight_preferred_pace_id'], 'The weight preferred pace id field is required.');
    }    
    
    public function testUserDietaryRequirementsRequired(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/savegoal', ['user_id' => 2, 'goals_id' => 1, 'goal_weight' => 134, 'weight_preferred_pace_id' => 3,
                                'dietary_requirements_id' => '', 'api_token' => $api_token]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['dietary_requirements_id'], 'The dietary requirements id field is required.');
    }
    
    /** @test **/
    public function testToGetUserGoalWithoutApiToken(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $this->post('/getgoal', ['api_token' =>'', 'user_id' => $user_id])
                ->seeStatusCode(401)
                ->seeJson([
                  'message' => 'Unauthorized user' //here we can check any or all key value are equal or not  
                ]);        
    } 
    
    /** @test **/
    public function testToGetUserGoalwithoutUserId(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/getgoal', ['api_token' =>$api_token, 'user_id' => '']);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['user_id'], 'The user id field is required.');        
    }
    /** @test **/
    public function testToGetUserGoalUserIdWithChar(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/getgoal', ['api_token' =>$api_token, 'user_id' => 'TEST']);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['user_id'], 'The user id must be a number.');        
    }    
    
//    /** @test **/
//    public function testToGetUserGoal(){
//        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
//        $this->assertEquals(200, $response->getStatusCode());
//        $data = json_decode($response->getContent(), true);
//        $user_id = $data['data']['id'];
//        $api_token = $data['data']['api_token'];
//        $this->post('/getgoal', ['api_token' =>$api_token, 'user_id' => $user_id])
//                ->seeStatusCode(200)
//                ->seeJson([
//                  'isupdated' => 1 //here we can check any or all key value are equal or not  
//                ]);
//    }
    
    /** @test **/
    public function testToGetUserGoalData(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $response = $this->call('POST', '/getgoal', ['api_token' =>$api_token, 'user_id' => $user_id]);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('goals', $data);
        $this->assertArrayHasKey('dietryrequirements', $data);
        $this->assertArrayHasKey('preferredpace', $data);
        $this->assertNotNUll($data['goals']);
        $this->assertNotNUll($data['dietryrequirements']);
        $this->assertNotNUll($data['preferredpace']);
        $this->assertNotNUll($data['data']);
    }    
    
}