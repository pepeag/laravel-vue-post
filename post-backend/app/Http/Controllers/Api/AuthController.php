<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Service\AuthServiceInterface;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

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
            return send_error('Unauthorised User', '', 401);
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

            $user = $this->authService->register($request);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
            ];

            return send_response('User registeration Successfully', $data);
        } catch (\Exception $e) {
            return send_error($e->getMessage(), $e->getCode());
        }
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->json(['message' => 'successfully logout']);
    }

    public function index()
    {
        $data = $this->authService->index();
        return send_response('All Users', $data);
    }
}
