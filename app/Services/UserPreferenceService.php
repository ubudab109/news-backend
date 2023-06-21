<?php

namespace App\Services;

use App\Constants\PreferenceType;
use App\Interfaces\UserPreferenceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPreferenceService
{
    /**
     * @var App\Interface\UserPreferenceInterface
     */
    protected $preference;

    /**
     * Constructor
     * @param UserPreferenceInterface $preference
     */
    public function __construct(UserPreferenceInterface $preference)
    {
        $this->preference = $preference;
    }

    /**
     * Get User Preference Setting
     * 
     * @return array
     */
    public function getPreferenceUser()
    {
        $user = Auth::user();
        return [
            'status' => true,
            'data'   => $this->preference->getUserPreference($user),
        ];
    }

    /**
     * Save User preference setting
     * @param array $types - Refer to PreferenceType constant
     * @param array $data
     * @return array
     */
    public function savePreferences(array $types, array $data)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            foreach($types as $key => $type) {
                $keyPreference = PreferenceType::searchValue($type);
                $preferenceType = PreferenceType::$keyPreference();
                $this->preference->updateOrCreatePreference($user, $preferenceType, $data[$key]);
            }
            DB::commit();
            return [
                'success' => true,
                'message' => 'Preference Setting Saved Successfully',
                'data'    => $user->load('preferences'),
            ];
        } catch (\Exception $err) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => defaultErrorResponse($err->getMessage().' - '. $err->getLine()),
            ];
        }
    }
}