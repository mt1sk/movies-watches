<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitGlobalsController extends Controller
{
    public function init(Request $request) {
        $data = [];
        $data['user'] = Auth::guard('api')->user();
        $data['app_name'] = config('app.name', 'Laravel');
        $data['root_url'] = url('/');
        return response()->json(['data' => $data]);
    }
}
