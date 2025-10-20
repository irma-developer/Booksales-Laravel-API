<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //1. setup validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        //2. cek  validator
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }
        //3. create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //4. cek keberhasilan
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data'    => $user,
            ], 201);
        }
        //5. cek gagal
        return response()->json([
            'success' => false,
            'message' => 'User creation failed',
        ], 409); // Conflict
    }

    public function login(Request $request)
    {
        //1. setup validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        //2. cek validator
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //3. Get kredensial dari cek
        $credentials = $request->only('email', 'password');
        // 4. Cek isFailed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah!'
            ], 401);
        }



        // 5. Cek isSuccess
        return response()->json([
            'success' => true,
            'message' => 'Login successfully',
            'user'    => auth()->guard('api')->user(),
            'token'   => $token,
        ], 200);
    }
}
