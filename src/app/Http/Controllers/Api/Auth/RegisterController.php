<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return response(null, 201);
    }
}
