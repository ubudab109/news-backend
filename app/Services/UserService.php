<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{
    /** @var UserInterface */
    protected $user;

    /**
     * Constructor
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Process update user data
     * @param array $data
     * @return array
     */
    public function updateUserData(array $data)
    {
        $userData = null;
        $id = Auth::user()->id;
        DB::transaction(function () use ($data, $id, &$userData) {
            $update = $this->user->updateData($id, $data);
            $userData = $update;
        }, 2);

        if (!$userData) {
            return [
                'success' => false,
                'message' => 'There is an error when updating the data',
                'data'    => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Data updated successfully',
            'data'    => $userData,
        ];;
    }
}
