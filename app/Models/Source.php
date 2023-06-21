<?php

namespace App\Models;

use App\Factories\AdapterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Source
 * 
 * @property int $id
 * @property string $name
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 */
class Source extends Model
{
    use HasFactory;

    const NEWS_API_AI = 1000;
    const THE_GUARDIAN = 1001;
    const NEWS_API_ORG = 1002;

    const SOURCES = [
        self::NEWS_API_AI   => 'NewsAPIAI',
        self::THE_GUARDIAN  => 'TheGuardian',
        self::NEWS_API_ORG  => 'NewsAPIORG',
    ];

    protected $client = null;
    protected $authorAdapter = null;
    protected $categoryAdapter = null;
    protected $articleAdapter = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'key'];

    /**
     * Returns the Client based on the integration
     *
     * @return AbstractClient
     * @throws \Exception
     */
    public function getClient()
    {
        if (empty($this->client)) {
            $this->client = AdapterFactory::create($this, 'Client');
        }
        return $this->client;
    }

    /**
     * Returns the Author Adapter based on the integration
     *
     * @return AbstractAuthorAdapter
     * @throws \Exception
     */
    public function getAuthorAdapter()
    {
        if (empty($this->authorAdapter)) {
            $this->authorAdapter = AdapterFactory::create($this, 'Author');
        }
        return $this->authorAdapter;
    }

    /**
     * Returns the Category Adapter based on the integration
     *
     * @return AbstractCategoryAdapter
     * @throws \Exception
     */
    public function getCategoryAdapter()
    {
        if (empty($this->categoryAdapter)) {
            $this->categoryAdapter = AdapterFactory::create($this, 'Category');
        }
        return $this->categoryAdapter;
    }

    /**
     * Returns the Article Adapter based on the integration
     *
     * @return AbstractArticleAdapter
     * @throws \Exception
     */
    public function getArticleAdapter()
    {
        if (empty($this->articleAdapter)) {
            $this->articleAdapter = AdapterFactory::create($this, 'Article');
        }
        return $this->articleAdapter;
    }

    /**
     * Get articles data that related to Source
     * 
     * @return HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'source_id', 'id');
    }

    /**
     * Get authors data the related to Source
     * 
     * @return HasMany
     */
    public function authors()
    {
        return $this->hasMany(Author::class, 'source_id', 'id');
    }

    /**
     * Get categories data that related to Source
     * 
     * @return HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'source_id', 'id');
    }
}
