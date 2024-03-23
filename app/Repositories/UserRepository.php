<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function create(array $data) {
        return User::create($data);
    }

    public function findByEmail( $email ){
        return User::where( 'email', $email )->first();
    }

}
