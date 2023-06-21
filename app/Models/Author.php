<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Author
 * 
 * @property int $source_id
 * @property string $external_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 */
class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['source_id', 'external_id', 'name', 'email'];

    /**
     * Retrieve Source data that Belongs To Author
     * 
     * @return BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }
}
