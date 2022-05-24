<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Service\UserServiceInterface;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->index();

        return send_response('All Users', $data);
    }

    public function show($id)
    {
        $user = $this->userService->show($id);
        if ($user) {
            return send_response('Success', $user);
        } else {
            return send_error('User Data Not Found');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return send_error('Validation Error', $validator->errors(), 422);
        }

        try {

            $user = $this->userService->update($request, $id);

            return send_response('User Update Successfully', $user);
        } catch (\Exception $e) {
            return send_error($e->getMessage(), $e->getCode());
        }
    }

    public function getUser()
    {
        $user = Auth::user();
        return send_response("Login User", $user);
    }

    public function deleteUser($id)
    {
        $user = $this->userService->delete($id);
        return send_response("User Delete Success", $user);
    }
}
