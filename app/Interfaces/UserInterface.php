<?php

namespace App\Interfaces;

interface UserInterface
{
    /**
     * Update data user (Only email and Name)
     * @param int $id
	 * @param array $data
     * @return User
     */
	public function updateData(int $id, array $data);
}