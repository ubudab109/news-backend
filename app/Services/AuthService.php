<?php

namespace App\Services;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthInterface
{
    /**
    * @var User
    */
    protected $model;

    /**
     * Constructor
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Login process, getting data from database
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login($email, $password)
    {
        $userData = $this->model->where('email', $email)->first();
        if (!$userData || !Hash::check($password, $userData->password)) {
            return [
                'success' => false,
                'message' => 'Credential Not Found. Please Register Here',
            ];
        }

        $token = $userData->createToken('user_token')->plainTextToken;
        return [
            'success' => true,
            'data'    => [
                'token' => $token,
                'user'  => $userData->load('preferences')
            ],
            'message' => 'Successfully Login'
        ];
    }

    /**
     * Register process then save data to database
     * @param string $email
     * @param string $name
     * @param string $password
     * @return array
     */
    public function register($email, $name, $password)
    {
        DB::beginTransaction();
        try {
            $userData = $this->model->create([
                'email'    => $email,
                'name'     => $name,
                'password' => Hash::make($password),
            ]);
            $token = $userData->createToken('user_token')->plainTextToken;
            DB::commit();
            return [
                'success' => true,
                'message' => 'Registered Successfully',
                'data'    => [
                    'token' => $token,
                    'user'  => $userData->load('preferences')
                ],
            ];
        } catch (\Exception $err) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => defaultErrorResponse($err->getMessage()),
            ];
        }
    }
}
