<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;
use PhpParser\Node\Expr\FuncCall;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return send_error('Validation Error', $validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $data['name'] = $user->name;
            $data['access_token'] = $user->createToken('accessToken')->accessToken;

            return send_response('You are successfully logged in', $data);
        } else {
            return send_error('Unauthorised', '', 401);
        }

        try {
        } catch (\Exception $e) {
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:4",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);

        if ($validator->fails()) {
            return send_error('Validation Error', $validator->errors(), 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
            ];

            return send_response('User registeration Successfully', $data);
        } catch (\Exception $e) {
            return send_error($e->getMessage(), $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();
        return response()->json(['message' => 'successfully logout']);
    }
    
    public function index()
    {
        $data = User::all();
        return send_response('All Users', $data);
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return send_response('Success', $user);
        } else {
            return send_error('User Data Not Found');
        }
    }
}
