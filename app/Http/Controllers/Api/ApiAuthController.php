<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function index(User $user)
    {
        $user = $user->all()->chunk(10000);
        return response([
            'user' => $user,
            'message' => 'Successful'
        ], 200);
    }
}
