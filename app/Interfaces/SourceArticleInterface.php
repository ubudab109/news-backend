<?php

namespace App\Interfaces;

interface SourceArticleInterface
{
    /**
     * Create or update articles from each sources
     * 
     * @throws \Exception
     */
    public function createOrUpdateArticle();
}