<?php

namespace App\Sources;

use App\Factories\AdapterFactory;
use App\Interfaces\SourceArticleInterface;
use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class AbstractArticleAdapter implements SourceArticleInterface 
{
    /**
     * @var Source
     */
    protected $source;
    protected $client;

    /**
     * Abstract Author Adapter Constructor
     * @param Source $source
     * @throws \Exeption
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
        $this->client = AdapterFactory::create($source, 'Client');
    }

    /**
     * Returns the Client object for the account
     *
     * @return object
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Handles creating or updating the authors data
     * 
     * @param TransformedArticle $transformedArticle
     * @return Article|void|null
     */
    public function handleArticles(TransformedArticle $transformedArticle)
    {
        $createdArticle = null;
        DB::transaction(function () use (&$transformedArticle, &$createdArticle) {
            $transformedArticle = $transformedArticle->createOrUpdateArticle($this->source);
            $createdArticle = $transformedArticle->fresh();
        }, 3);

        if (!$createdArticle) {
            Log::channel('test')->info('There is an error when transformed the article');
        }

        return $createdArticle;
    }

}