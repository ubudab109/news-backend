<?php

namespace App\Models;

use App\Constants\PreferenceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserPreference
 * 
 * @property int $user_id
 * @property string $type
 * @property string $data
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 */
class UserPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'data',
        'icon',
    ];

    /**
     * Attributest that want to update in model
     * 
     * @var array<int, string>
     */
    protected $appends = ['data_options', 'data_label']; 

    public function getDataLabelAttribute()
    {
        $prefs = json_decode($this->data);
        $data = [];
        foreach($prefs as $pref) {
            if ($this->type == PreferenceType::SOURCES()->getValue()) {
                $label = Source::find((int)$pref)->name;
            } else {
                $label = $pref;
            }
            $data[] = $label;
        }

        return $data;
    }

    /**
     * converts JSON data into an array of options with values and labels.
     * Append to $appends attribute
     * 
     * @return array
     */
    public function getDataOptionsAttribute()
    {
        $prefs = json_decode($this->data);
        $data = [];
        foreach($prefs as $pref) {
            if ($this->type == PreferenceType::SOURCES()->getValue()) {
                $label = Source::find((int)$pref)->name;
            } else {
                $label = $pref;
            }
            $data[] = [
                'value' => $pref,
                'label' => $label, 
            ];
        }

        return $data;
    }

    /**
     * Retrieve User data that Belongs to UserPreference
     * 
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
