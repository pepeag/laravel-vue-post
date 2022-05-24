<?php

namespace App\Dao;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Dao\UserDaoInterface;

class UserDao implements UserDaoInterface
{
  public function index()
  {
    $data = User::when(request('search'), function ($query) {
      $query->where('name', 'like', '%' . request('search') . '%');
      $query->orWhere('email', 'like', '%' . request('search') . '%');
    })->orderBy('id', 'desc')->paginate(3);

    return $data;
  }

  public function show($id)
  {
    return User::find($id);
  }

  public function update($request, $id)
  {
    $user = User::find($id);
    $user->name = $request->name;
    $user->email = $request->email;
    if ($user->password == $request->password) {
      $user->password = $request->password;
    } else {
      $user->password = Hash::make($request->password);
    }
    $user->save();

    return $user;
  }

  public function delete($id)
  {
    $user = User::find($id);
    $user->delete();

    return $user;
  }
}
