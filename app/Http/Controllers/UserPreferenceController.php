<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPreferenceRequest;
use App\Services\UserPreferenceService;

class UserPreferenceController extends BaseController
{
    /**
     * @var UserPreferenceServices
     */
    private $services;

    public function __construct(UserPreferenceService $services)
    {
        $this->services = $services;
    }

    /**
     * Process saving preference setting user
     * @param UserPreferenceRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(UserPreferenceRequest $request)
    {
        $input = $request->only('type', 'data');
        $saved = $this->services->savePreferences($input['type'], $input['data']);
        if (!$saved['success']) {
            return $this->sendError($saved['message']);
        }
        return $this->sendRespond($saved['data'], $saved['message']);
    }
}
