<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = User::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
            $query->orWhere('email', 'like', '%' . request('search') . '%');
        })->orderBy('id', 'desc')->paginate(3);

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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return send_error('Validation Error', $validator->errors(), 422);
        }
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

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
        $user = User::find($id);
        $user->delete();
        return send_response("User Delete Success", $user);
    }
}
