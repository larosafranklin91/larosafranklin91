<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function login(array $credentials)
    {

        if (Auth::attempt($credentials)) {
            return Auth::user(); 
        }

        throw new \Exception('Invalid credentials', 401);
    }
}
