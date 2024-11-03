<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

   public function register(RegisterRequest $request)
   {
        return ExceptionHandler::tryCatchWrapper(function() use ($request){
            return response()->json($this->userService->register($request), 201);
        });
   }

    public function login(LoginRequest $request)
    {
        return ExceptionHandler::tryCatchWrapper(function() use ($request){
            $user = $this->userService->login($request);

            if (!$user) {
                throw new \Exception('Invalid credentials', 401);
            }

            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24);

            return response()->json([
                'message' => 'Success',
                'token' => $token,
            ]);
        });
    }   
   

}
