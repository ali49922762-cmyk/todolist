<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','confirmed','min:8']
        ]);

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password'])
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'تم إنشاء الحساب بنجاح',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $validate['email'])->first();

        if (!$user || !Hash::check($validate['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'بيانات الدخول غير صحيحة'
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ]
        ]);
    }
}