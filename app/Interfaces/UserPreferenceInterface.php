<?php

namespace App\Interfaces;

use App\Constants\PreferenceType;
use App\Models\User;

interface UserPreferenceInterface
{
    /**
     * Get User Preference By User
     * @param User $user
     * @return Collection
     */
    public function getUserPreference(User $user);

    /**
     * Update or create user preferences settings based on type
     * @param User $user
     * @param PreferenceType $type
     * @param mixed $data
     * @return User
     */
    public function updateOrCreatePreference(User $user, PreferenceType $type, $data);
}