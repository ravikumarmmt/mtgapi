<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});
//$app->group(['middleware' => 'cors'], function () use ($app) {
    //$app->post('/register','UserController@store');
    //$app->put('/updateprofile/{profile_id}', 'UserProfileController@update');
    //$app->put('/updategoal/{goal_id}', 'UserGoalController@update');
//});


//Users
$app->get('/users', 'UserController@index');
$app->post('/register','UserController@store');
$app->get('/user/{user_id}','UserController@show');
$app->post('/user/{user_id}', 'UserController@update');
$app->delete('user/{user_id}', 'UserController@destroy');
$app->post('/login', 'UserController@login');


//User Profile
$app->post('/getprofile', 'UserProfileController@show');
$app->post('/saveprofile', 'UserProfileController@store');
$app->post('/updateprofile/{profile_id}', 'UserProfileController@update');

//$app->post('/test', ['middleware' => 'auth', 'uses'=>'UserController@sampleData']);
//$app->group(['middleware' => 'auth'], function () use ($app) {
//   $app->post('/test', 'UserController@sampleData');
//   $app->get('/users', 'UserController@index');
//   $app->post('/getprofile/{user_id}', function($user_id){
//       return $user_id;
//   }); 
//});

//$app->get('/user/{id}', function($id){
//    return $id;
//});
   
   
//User Goal
$app->post('/getgoal', 'UserGoalController@show');   
$app->post('/savegoal', 'UserGoalController@store');
$app->post('/updategoal/{goal_id}', 'UserGoalController@update');
$app->delete('goal/{goal_id}', 'UserGoalController@destroy');


//Food Preferences
$app->get('/foodpreferences', 'FoodprefenceController@index');
$app->post('/savefoodpreferences', 'FoodprefenceController@store');
$app->post('/updatefoodpreferences', 'FoodprefenceController@update');
$app->post('/getsubcategory', 'FoodprefenceController@getSubCategory');
$app->delete('foodpreferences/{id}', 'UserGoalController@destroy');


$app->post('/getMealPlan', 'MealPlanController@sendMealPlanToAlgorithm');


//Dashboard
$app->post('/weight', 'DashboardController@store');
$app->post('/getweightlists', 'DashboardController@getWeightLists');



$app->get('/dbdrop', function(){
  //Schema::dropIfExists('test'); 
});
