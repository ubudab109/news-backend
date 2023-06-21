<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;


class UserController extends BaseController
{
    /** @var UserService */
    private $services;

    /**
     * Constructor
     * @param UserService
     */
    public function __construct(UserService $services)
    {
        $this->services = $services;
    }

    /**
     * Request update data user
     * @param UserUpdateRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request)
    {
        $input = $request->only('email', 'name');
        $updateUser = $this->services->updateUserData($input);
        if (!$updateUser['success']) {
            return $this->sendError('Failed', $updateUser['message']);
        }
        return $this->sendRespond($updateUser['data'], $updateUser['message']);
    }
}
