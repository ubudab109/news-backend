<?php

namespace App\Interfaces;

interface SourceCategoryInterface
{
    /**
     * Create or update categories from each sources
     * 
     * @throws \Exception
     */
    public function createOrUpdateCategories();
}