<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser($data)
    {
        $userExists = $this->userRepository->findByEmail($data['email']);
        if ($userExists) {
            return false;
        }
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        
        // TODO: Send notification through Node.js service
        // TODO: Return user or other needed information

        return $user;
    }

    public function login($credentials) {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token
        ];
    }


}
