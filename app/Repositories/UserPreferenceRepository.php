<?php

namespace App\Repositories;

use App\Constants\PreferenceType;
use App\Interfaces\UserPreferenceInterface;
use App\Models\User;

class UserPreferenceRepository implements UserPreferenceInterface
{
    /**
     * Get User Preference By User
     * @param User $user
     * @return Collection
     */
    public function getUserPreference(User $user)
    {
        $data = $user->preferences()->orderBy('type', 'asc')->get();
        return $data;
    }

    /**
     * Update or create user preferences settings based on type
     * @param User $user
     * @param PreferenceType $type
     * @param mixed $data
     * @return bool|array
     */
    public function updateOrCreatePreference(User $user, PreferenceType $type, $data)
    {
        return $user->savePreferences($type, $data);
    }
}