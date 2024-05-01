<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                "name" => $req->name,
                "email" => $req->email,
                "password" => Hash::make($req->password)
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'User created successfully',
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500, 
                'error' => 'Failed to registration, Please try again!!.'
            ], 500);
        }
    }


    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        } 

        $credentials = $req->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['status' => 401, 'error' => 'Unauthorized'], 401);
        }

        // if(! $token = auth()->attempt(["email"=> $req->email, "password"=> $req->password])){
        //     return response()->json(['status'=> 401,'error' => 'Unauthorized'], 401);
        // }

        // if (Auth::attempt($credentials)) {
        //     // Authentication passed...
        //     return response()->json(['message' => 'Authenticated successfully'], 200);
        // } else {
        //     // Authentication failed...
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }

        return $this->createNewToken($token);
    }

    public function profile(){
        
        return response()->json(auth()->user(), 200); 
    //     if (auth()->check()) {
    //         $user = auth()->user();
    //         return response()->json($user, 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(["status"=>200, "message" => "User logged out successfully"], 200);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    
    protected function createNewToken($token)
    {
        // Set the token as an HTTP-only cookie
        //$cookie = cookie('access_token', $token, auth()->factory()->getTTL() * 60, '/', null, false, true);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
