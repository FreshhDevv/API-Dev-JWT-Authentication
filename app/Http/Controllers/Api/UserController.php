<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // USER REGISTER API - POST
    public function register(Request $request) {
        // VALIDATION
        $request->validate([
            'name' => 'required',
            'email' => 'required | email | unique:users',
            'phone_no' => 'required',
            'password' => 'required | confirmed'
        ]);

        //CREATE USER DATA
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->password = bcrypt($request->password);

        $user->save();

        //SEND RESPONSE
        return response()->json([
            'status'=> 1,
            'message'=>'User registered successfully'
        ],200);


    }

    // USER LOGIN API - POST
    public function login(Request $request) {
        // VALIDATION
        $request->validate([
            'email'=> 'required | email',
            'password' => 'required'
        ]);

        // VERIFICATION + TOKEN
        // After verifying the user we need to create the JWT token
        if(!$token = auth()->attempt(['email'=>$request->email, 'password'=>$request->password])) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid Credentials'
            ], 401);
        }

        // SEND RESPONSE
        return response()->json([
            'status'=>1,
            'message'=>'User loggedin successfully',
            'access_token' => $token
        ]);
    }

    // USER PROFILE API - GET
    public function profile() {
        $user_data = auth()->user();

        return response()->json([
            'status'=> 1,
            'message' => 'User Profile Information',
            'data' => $user_data
        ]);

    }

    // USER LOGOUT API - GET
    public function logout() {

    }
}
