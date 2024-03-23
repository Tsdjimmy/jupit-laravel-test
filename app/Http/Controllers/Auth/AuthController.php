<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Events\UserRegistered;
use App\Services\RabbitMQService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller {
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request) {

        $user = $this->userService->registerUser($request->toArray());
        if (!$user) {
            return response()->json(['status' => true, 'message' => 'Registration Failed', 'code' => 403, 'data' => ['user' => $user, 'access_token' => null]], 403);

        }
        $token = $user->createToken('authToken')->plainTextToken;
        
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish([
            'email' => $user->email,
            'message' => 'Welcome to our application!',
        ]);
        return response()->json(['status' => true, 'message' => 'Registration Successful', 'code' => 200, 'data' => ['user' => $user, 'access_token' => $token]], 200);

    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->userService->login($request->toArray());
        if (!$user) {
            return response()->json(['status' => true, 'message' => 'Unauthorized', 'code' => 401, 'data' => null], 403);
        }

        return response()->json(['status' => true, 'message' => 'Login Successul', 'code' => 200, 'data' => $user], 200);
    }
}
