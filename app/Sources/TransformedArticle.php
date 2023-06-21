<?php

namespace App\Sources;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Facades\Log;

class TransformedArticle
{
    public $externalId;
    public $author;
    public $category;
    public $title;
    public $content;
    public $thumbnail;
    public $publishedDate;
    public $url;

    /**
     * Transformed Article Constructor
     * 
     * @param string|null $externalId - main identified from external source
     * @param string|null $author
     * @param string|null $category
     * @param string $content
     * @param string|null $thumbnail
     * @param string $publishedDate
     * @param string $url
     */
    public function __construct($externalId, $author, $category, $title, $content, $thumbnail, $publishedDate, $url)
    {
        $this->externalId = $externalId;
        $this->author = $author;
        $this->category = $category;
        $this->title = $title;
        $this->content = $content;
        $this->thumbnail = $thumbnail;
        $this->publishedDate = $publishedDate;
        $this->url = $url;
    }

    /**
     * Transform the articles format for each source the save to database
     * @param Source $source
     * @throws \Exception
     * @return Article
     */
    public function createOrUpdateArticle(Source $source)
    {
        $savedSources = $source->articles()->updateOrCreate([
            'source_id'   => $source->id, 
            'external_id' => $this->externalId
        ], [
            'source_id'      => $source->id,
            'external_id'    => $this->externalId,
            'author'         => $this->author,
            'category'       => $this->category,
            'title'          => $this->title,
            'content'        => $this->content,
            'thumbnail'      => $this->thumbnail,
            'published_date' => date('Y-m-d h:i:s', strtotime($this->publishedDate)),
            'url'            => $this->url,
        ]);
        if (is_bool($savedSources)) {
            if (!$savedSources) {
                throw new \Exception('Failed to create or update articles');
            }
            $articles = $source->articles()->where([
                'souce_id'    => $source->id,
                'external_id' => $this->externalId,
                'author'      => $this->author,
                'category'    => $this->category,
            ])->first();
        } else {
            $articles = $savedSources;
        }

        return $articles;
    }

}