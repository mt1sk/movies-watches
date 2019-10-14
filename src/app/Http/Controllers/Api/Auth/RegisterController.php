<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\User;
use Carbon\Carbon;
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

        $token = $user->createToken(config('app.name').', auto api auth.');
        $token->token->expires_at = Carbon::now()->addMonth();
        $token->token->save();

        $tokenResult = [
            'token_type' => 'Bearer',
            'access_token' =>  $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
        ];
        return response()->json([
            'data' => [
                'token'=>$tokenResult,
            ],
        ], 201);
    }
}
