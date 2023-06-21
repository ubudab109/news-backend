<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 * 
 * @property int $source_id
 * @property string $external_id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['source_id', 'external_id', 'label'];

    /**
     * Retrieve Source data that Belongs To Category
     * 
     * @return BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }
}
