<?php

namespace App\Http\Controllers;

use App\Models\User;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    private $success_status = 200;

    //Register user
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|alpha_num|min:6',
                
            ]
        );

        // validate input
        if($validator->fails())
        {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $dataArray = array(
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),

        );

        //register/create new user
        $user = User::create($dataArray);

        if(!is_null($user))
        {
            return response()->json(["status" => $this->success_status, "success" => true, "data" => $user]);
        }
        else
        {
            return response()->json(["status" => "failed", "success" => false, "message" => "Failed! user not registred. please try again."]);
        }

    }

    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|alpha_num|min:6',
                
            ]
        );

        // validate input
        if($validator->fails())
        {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $dataArray = array(
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "role" => "admin",

        );

        //register/create new user
        $user = User::create($dataArray);

        if(!is_null($user))
        {
            return response()->json(["status" => $this->success_status, "success" => true, "data" => $user]);
        }
        else
        {
            return response()->json(["status" => "failed", "success" => false, "message" => "Failed! user not registred. please try again."]);
        }

    }

    //user login function
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|alpha_num|min:6'
            ]
    
        );

        if ($validator->fails()) 
        {
            return view('login',response()->json(["validation_errors" => $validator->errors()]));
            
        }

        if (Auth::attempt(['email'=> $request->email, 'password'=> $request->password])) {
            
            $user = Auth::user();
            $token = $user->createToken('token')->accessToken;

            return response()->json([ "user_id" => $user->id,  "token" => $token,"status" => $this->success_status, "message" => "Access Granted"]);
        }
        else
        {
            return response()->json(["status" => "failed", "success" => false, "message" => "Error! invalid email or password"]);
        }

        
    }


    public function userDetail() {
       $user           =       Auth::user();
    
        if(!is_null($user)) {
            return response()->json(["status" => $this->success_status, "success" => true, "user" => $user]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no user found"]);
        }
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|alpha_num|min:6',
                
            ]
        );

        // validate input
        if($validator->fails())
        {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $exist_user = User::find($user->id);

        if ($exist_user) {
            $exist_user->name = $request->name;
            $exist_user->email = $request->email;
            $exist_user->password = bcrypt($request->password);
            $exist_user->save();
            return response()->json(["status" => $this->success_status, "Message" => "User information has been updated.", "Data" => $exist_user]);

        }

        return response()->json(["status" => "User not found!"]);
        

    }

    public function deleteUser($id)
    {
        $user = Auth::user();
        $exist_user = User::find($id);

        if ($exist_user) {
            $exist_user->delete();
            return response()->json(["status" => $this->success_status, "message" => "User successfully deleted"]);
        }

        return response()->json(["status" => "User not found!"]);
    }

    
}
