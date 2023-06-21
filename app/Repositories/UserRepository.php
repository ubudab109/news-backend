<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    /**
    * @var User
    */
    protected $model;

	/**
	 * Constructor
	 * @param User $user
	 */
    public function __construct(User $model)
    {
		$this->model = $model;
    }

	/**
     * Update data user (Only email and Name)
     * @param int $id
	 * @param array $data
     * @return User
     */
	public function updateData(int $id, array $data)
	{
		$notify = tap($this->model->where('id', $id)->with('preferences'))->update($data)->first();
		return $notify;
	}
}