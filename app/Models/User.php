<?php

namespace App\Models;

use App\Constants\PreferenceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Retrieve preferences data that related from User
     * 
     * @return HasMany
     */
    public function preferences()
    {
        return $this->hasMany(UserPreference::class, 'user_id', 'id');
    }

    /**
     * Get spesific preferences by type
     * @param PreferenceType $type
     * @return UserPreference
     */
    public function preferenceType(PreferenceType $type)
    {
        return $this->preferences()->where('type', $type->getValue())->first();
    }

    /**
     * Saves user preferences as JSON data in a database.
     * 
     * @param PreferenceType $type
     * @param array $data - Data preferences to save
     * 
     * @return bool | array
     */
    public function savePreferences(PreferenceType $type, array $data)
    {
        return $this->preferences()->updateOrCreate([
            'user_id' => $this->id,
            'type'    => $type->getValue(),
        ], [
            'type'    => $type->getValue(),
            'data'    => json_encode($data),
        ]);
    }
}
