<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => "false",
                "errors" => $validator->errors()
            ]);
        }

        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();
        $token = $users->createToken('auth_token')->plainTextToken;

        return response()->json([
            "success" => true,
            "token" => $token,
            "message" => "Account created successfully",
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => "false",
                "errors" => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "success" => false,
                "token" => "null",
                "message" => "Invalid Credientals",
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "success" => true,
            "token" => $token,
            "message" => "Logged In successfully",
        ]);
    }
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Logged Out Sucessfully"
        ]);
    }
}
