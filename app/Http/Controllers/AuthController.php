<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    /**
     * @var AuthServices
     */
    private $services;

    /**
     * Constructor
     * @param AuthService $services
     */
    public function __construct(AuthService $services)
    {
        $this->services = $services;
    }

    /**
     * Process Login Request
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');
        $login = $this->services->login($input['email'], $input['password']);
        if (!$login['success']) {
            return $this->sendUnauthorized($login['message']);
        }
        return $this->sendRespond($login['data'], $login['message']);
    }

    /**
     * Process Register Request
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $register = $this->services->register($input['email'], $input['name'], $input['password']);
        if (!$register['success']) {
            return $this->sendError($register['message']);
        }
        return $this->sendRespond($register['data'], $register['message']);
    }

    /**
     * Logout Process
     * 
     * @return Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendRespond(null, 'Successfully Logout');
    }
}
