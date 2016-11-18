<?php 

namespace App\Http\Controllers;

use App\User;
use App\WeeklyUpdate;


use database\migrations\CreateUsersGoalTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;  
use Auth;


class DashboardController extends Controller
{
    /**
     * 
     * User Authentication used in construct method.
     * Authorizes user only to access sampleData method 
     * 
     */    
    public function __construct(User $user) {
        $this->middleware('auth', ['only' => ['store', 'getWeightLists']]);
    }//End of construct
    
    /**
     * 
     * Method to update and save user weight information in database
     * 
     * 
     */
    public function store(Request $request){
        $this->validateRequest($request);
        $weeklyupdate = WeeklyUpdate::find($request->input('id'));
        if($weeklyupdate){ // For update
       // if($weeklyupdate){ //For Insert
            $weeklyupdateinsert = WeeklyUpdate::create([
                'user_id' => $request->input('user_id'),
                'weight' => $request->input('weight')
            ]);
            if($weeklyupdateinsert)
                return response()->json(['status' => 1, 'message' => 'Data inserted successfully', 'data' => $weeklyupdateinsert]);
            return response()->json(['status' => 1, 'message' => 'Data was not inserted'], 422);
        } else {
            $weeklyupdate->user_id = $request->input('user_id');
            $weeklyupdate->weight = $request->input('weight');
            $weeklyupdate->save();
            if($weeklyupdate)
                return response()->json(['status' => 1, 'message' => 'User weight has been updated', 'data' => $weeklyupdateinsert]);
            return response()->json(['status' => 1, 'message' => 'Data was not updated'], 422);
        }
        
    } 
    
    /**
     * 
     * Method to show user weights based upon weekly
     * 
     * @param $request
     * 
     * @return Response
     * 
     */
    public function getWeightLists(Request $request){
        $this->validateRequest($request);
        $weeklyupdate = WeeklyUpdate::where('user_id', $request->input('user_id'))->get(['id', 'user_id', 'weight',
                        DB::raw("STR_TO_DATE(created_at, '%Y-%m-%d') as created_at"),
                        DB::raw("STR_TO_DATE(updated_at, '%Y-%m-%d') as updated_at")]);
        if(count($weeklyupdate)>0)
            return response()->json(['status' => 1, 'data' => $weeklyupdate]);
        return response()->json(['status' => 1,'data' => "The user with id {$request->input('user_id')} doesn't exist"]);
    }
   
     /**
     * Method for validate u  ser inputs.
     *
     * @param $request
     * 
     * @return Response
     */  
    public function validateRequest(Request $request){
        $rules = [
                'user_id' => 'required|numeric',
            ];

        $this->validate($request, $rules);
    }//End of validateRequest   
    
} //End Of Dashboard Controller