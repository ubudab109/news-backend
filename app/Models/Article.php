<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Article
 * 
 * @property int $id
 * @property int $source_id
 * @property string $external_id
 * @property string $author
 * @property string $category
 * @property string $title
 * @property string $content
 * @property string $thumbnail
 * @property string $published_date
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 */
class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['source_id', 'external_id', 'author', 
    'category', 'title', 'content', 'thumbnail', 'published_date', 'url'];

    /**
     * Retrieve Source data that Belongs To Article
     * 
     * @return BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }
}
