<?php

use App\User;
use App\UserFoodPreference;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;

class FoodprefenceTest extends TestCase
{
    public function testGetFoodPreferences(){
        $response = $this->call('GET', '/foodpreferences');
        $this->assertEquals(200, $response->status());
    }
    public function testGetFoodPreferencesSubcategoryWithoutToken(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];        
        $response = $this->call('POST', '/getsubcategory', ['api_token' =>'' , 'user_id' => $user_id, 'category_id' => 2]);
        $this->assertEquals(401, $response->getStatusCode());
    }    
    public function testGetFoodPreferencesSubcategoryWithoutUserId(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];        
        $response = $this->call('POST', '/getsubcategory', ['api_token' =>$api_token, 'user_id' => '', 'category_id' => 2]);
        $data = json_decode($response->getContent(), true);
       $this->assertEquals($data['data']['user_id'], 'The user id field is required.');
    }
    public function testGetFoodPreferencesSubcategoryUserIdWithChar(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];        
        $response = $this->call('POST', '/getsubcategory', ['api_token' =>$api_token, 'user_id' => 'test', 'category_id' => 2]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['user_id'], 'The user id must be a number.');
    }     
    public function testGetFoodPreferencesSubcategoryWithoutcategory_id(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];        
        $response = $this->call('POST', '/getsubcategory', ['api_token' =>$api_token, 'user_id' => $user_id, 'category_id' =>'']);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['category_id'], 'The category id field is required.');
    } 
    public function testGetFoodPreferencesSubcategoryCategory_idWithChar(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];        
        $response = $this->call('POST', '/getsubcategory', ['api_token' =>$api_token, 'user_id' => $user_id, 'category_id' => 'test' ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['category_id'], 'The category id must be a number.');
    }
    public function testGetFoodPreferencesSubcategory(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];        
        $response = $this->call('POST', '/getsubcategory', ['api_token' => $api_token, 'user_id' => $user_id, 'category_id' => 2]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotNUll($data['data']);
    }    

    /** @test **/
    public function saveFoodPreferenceWithoutApiToken(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $data = json_decode('[{"id":1,"checked":0},{"id":2,"checked":0},{"id":3,"checked":1},{"id":4,"checked":0},{"id":5,"checked":0},{"id":6,"checked":0},{"id":7,"checked":0},{"id":8,"checked":0},{"id":9,"checked":0},{"id":10,"checked":0},{"id":11,"checked":1},{"id":12,"checked":0}]', true);
        $sub_category = json_encode($data);
        $response = $this->call('POST', '/savefoodpreferences', ['api_token' =>'', 'user_id' => $user_id, 'parent_id' => 1,'sub_category' => $sub_category]);
        $this->assertEquals(401, $response->getStatusCode());        
    }

    /** @test **/
    public function saveFoodPreferenceWithoutUserId(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $data = json_decode('[{"id":1,"checked":0},{"id":2,"checked":0},{"id":3,"checked":1},{"id":4,"checked":0},{"id":5,"checked":0},{"id":6,"checked":0},{"id":7,"checked":0},{"id":8,"checked":0},{"id":9,"checked":0},{"id":10,"checked":0},{"id":11,"checked":1},{"id":12,"checked":0}]', true);
        $sub_category = json_encode($data);
        $response = $this->call('POST', '/savefoodpreferences', ['api_token' =>$api_token, 'user_id' => '', 'parent_id' => 1,'sub_category' => $sub_category]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['user_id'], 'The user id field is required.');     
    }    

    /** @test **/
    public function saveFoodPreferenceUserIdWithChar(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $data = json_decode('[{"id":1,"checked":0},{"id":2,"checked":0},{"id":3,"checked":1},{"id":4,"checked":0},{"id":5,"checked":0},{"id":6,"checked":0},{"id":7,"checked":0},{"id":8,"checked":0},{"id":9,"checked":0},{"id":10,"checked":0},{"id":11,"checked":1},{"id":12,"checked":0}]', true);
        $sub_category = json_encode($data);
        $response = $this->call('POST', '/savefoodpreferences', ['api_token' =>$api_token, 'user_id' => 'test', 'parent_id' => 1,'sub_category' => $sub_category]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['user_id'], 'The user id must be a number.');   
    }     

    /** @test **/
    public function saveFoodPreferenceWithoutcategory_id(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $sub_category = json_encode("[{'id':1,'checked':0},{'id':2,'checked':0},{'id':3,'checked':0},{'id':4,'checked':0},{'id':5,'checked':0},{'id':6,'checked':0},{'id':7,'checked':0},{'id':8,'checked':0},{'id':9,'checked':0},{'id':10,'checked':0},{'id':11,'checked':1},{'id':12,'checked':0}]");
        $response = $this->call('POST', '/savefoodpreferences', ['api_token' =>$api_token, 'user_id' => $user_id, 'parent_id' => '','sub_category' => $sub_category]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['parent_id'], 'The parent id field is required.');  
    }     

    /** @test **/
    public function saveFoodPreferenceCategory_idWithChar(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $data = json_decode('[{"id":1,"checked":0},{"id":2,"checked":0},{"id":3,"checked":1},{"id":4,"checked":0},{"id":5,"checked":0},{"id":6,"checked":0},{"id":7,"checked":0},{"id":8,"checked":0},{"id":9,"checked":0},{"id":10,"checked":0},{"id":11,"checked":1},{"id":12,"checked":0}]', true);
        $sub_category = json_encode($data);
        $response = $this->call('POST', '/savefoodpreferences', ['api_token' =>$api_token, 'user_id' => $user_id, 'parent_id' => 'TEST','sub_category' => $sub_category]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['parent_id'], 'The parent id must be a number.');  
    }
    /** @test **/
    public function saveFoodPreferenceWithoutSubCategory_id(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = $data['data']['id'];
        $api_token = $data['data']['api_token'];
        $data = json_decode('[{"id":1,"checked":0},{"id":2,"checked":0},{"id":3,"checked":1},{"id":4,"checked":0},{"id":5,"checked":0},{"id":6,"checked":0},{"id":7,"checked":0},{"id":8,"checked":0},{"id":9,"checked":0},{"id":10,"checked":0},{"id":11,"checked":1},{"id":12,"checked":0}]', true);
        $sub_category = json_encode($data);
        $response = $this->call('POST', '/savefoodpreferences', ['api_token' =>$api_token, 'user_id' => $user_id, 'parent_id' => 'TEST','sub_category' => '']);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data['data']['sub_category'], 'The sub category field is required.');  
    }
    /** @test **/
    public function saveFoodPreference(){
        $response = $this->call('POST', '/login', ['name' => 'ravi', 'email' => 'ravik@enqos.com', 'password' => 'test@123']);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $user_id = 2;
        $api_token = $data['data']['api_token'];
        $sub_category = json_decode('[{"id":1,"checked":0},{"id":2,"checked":0},{"id":3,"checked":1},{"id":4,"checked":0},{"id":5,"checked":0},{"id":6,"checked":0},{"id":7,"checked":0},{"id":8,"checked":0},{"id":9,"checked":0},{"id":10,"checked":0},{"id":11,"checked":1},{"id":12,"checked":0}]', true);
        $sub_category = json_encode($sub_category);
        $this->post('/savefoodpreferences', ['api_token' => $api_token, 'user_id' => $user_id, 'parent_id' => 1,'sub_category' => $sub_category])
                   ->seeStatusCode(200)
                   ->seeJson([
                       'message' => 'Food prference details have been saved successfully'
                   ]);
        
    }

    /** @test **/
//    public function toDeletetUserFoodPreferences(){
//        $user_found = UserFoodPreference::where('user_id', 2);
//        $user_found->delete();
//        $this->notSeeInDatabase('users_food_preference', ['user_id' => 2]);
//    }

    
}

