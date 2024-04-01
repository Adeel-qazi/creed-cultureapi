<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            if (Auth::attempt(["email" => $validatedData["email"], "password" => $validatedData["password"]])) {
                $user = auth()->user();
                
                if ($user->email_verified == 1) {
                    $token = $user->createToken('user')->accessToken;

                    return response()->json(['status' => true, 'access_token' => $token, 'user' => $user],200);
                } else {
                    return response()->json(['status' => false, 'message' => 'You are not authorized to access.'],403);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid email or password'],401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        
    }
}
