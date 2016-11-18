<?php
namespace App\Http\Controllers;

use App\DietaryExclusions;
use App\UserProfile;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class MealPlanController extends Controller
{
    /**
     * 
     * User Authentication used in construct method.
     * Authorizes user only to access store, show method 
     * 
    */
    public function __construct() {
        
      //  $this->middleware('auth', ['only' => ['show', 'store', 'update', 'destroy']]);
    }//End of construct    
    
    public static function sendMealPlanToAlgorithm(Request $request){
        $send_mealPlan = DB::table('users_profile')
                            ->join('users_goal', 'users_profile.user_id', '=', 'users_goal.user_id')
                            ->join('current_activity_level', 'users_profile.activity_level', '=', 'current_activity_level.id')
                            ->join('goals', 'users_goal.goals_id', '=', 'goals.id')
                            ->where('users_profile.user_id', $request->input('user_id'))
                            ->get(['users_profile.weight as weight', 'users_goal.goal_weight as goal_weight', 
                                    DB::raw(" CASE
                                        WHEN goals.name = 'Weight Loss' THEN 'loss'
                                        WHEN goals.name = 'Weight Maintenance' THEN 'maintenance'
                                        WHEN goals.name = 'Weight Gain' THEN 'gain'
                                        END
                                        as goal"),
                                    DB::raw("FLOOR(DATEDIFF(CURRENT_TIMESTAMP(),users_profile.birthday)/365.5) as age"),
                                    DB::raw(" CASE 
                                            WHEN users_profile.gender = 'M' THEN 'male'
                                            WHEN users_profile.gender = 'F' THEN 'female'
                                            END
                                            as gender"),
                                    'users_profile.height as height', 'users_profile.exercise_days as exercise_days',
                                    'current_activity_level.name as activity_level']);
        $send_mealPlan = json_decode($send_mealPlan, true);
        $send_mealPlan = $send_mealPlan[0];
        $send_mealPlan['plan_type'] = $request->input('plan_type');
        $params = json_encode($send_mealPlan, JSON_NUMERIC_CHECK);
        $url = 'http://104.199.228.194:5000/meal_plan';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));                                                                        
        $response = curl_exec($ch);
        curl_close($ch);
        //print_r($response);   
        if($response)
            return response()->json(['status' => 1, 'data' => $response]);
    }
}
