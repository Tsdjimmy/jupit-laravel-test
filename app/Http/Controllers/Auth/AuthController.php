<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Constants\AppMessages;
use App\Services\RabbitMQService;
use App\Services\ResponseService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller {
    protected $userService;
    protected $responseService;

    public function __construct(UserService $userService, ResponseService $responseService) {
        $this->userService = $userService;
        $this->responseService = $responseService;
    }

    public function register(RegisterUserRequest $request) {

        $user = $this->userService->registerUser($request->toArray());
        if (!$user) {
            return $this->responseService->errorResponse(AppMessages::REGISTRATION_FAILED, Response::HTTP_BAD_REQUEST);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish([
            'email' => $user->email,
            'message' => AppMessages::WELCOME_MESSAGE,
        ]);
        return $this->responseService->successResponse(['user' => $user, 'access_token' => $token], AppMessages::REGISTRATION_SUCCESSFUL);
    }

    public function login(LoginRequest $request) {
        $user = $this->userService->login($request->toArray());
        if (!$user) {
            return $this->responseService->errorResponse(AppMessages::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
        }

        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish([
            'email' => $user['user']['email'],
            'message' => AppMessages::LOGIN_SUCCESSFUL,
        ]);

        return $this->responseService->successResponse($user, AppMessages::LOGIN_SUCCESSFUL);
    }

    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);
    
        $status = Password::sendResetLink($request->only('email'));
    
        return $status === Password::RESET_LINK_SENT
                    ? $this->responseService->successResponse(null, __($status))
                    : $this->responseService->errorResponse(__($status), 422);
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->userService->resetPassword($user, $password);
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? $this->responseService->successResponse(null, __($status))
                    : $this->responseService->errorResponse(__($status), 422);
    }
}
