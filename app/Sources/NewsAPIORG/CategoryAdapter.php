<?php

namespace App\Sources\NewsAPIORG;

use App\Sources\AbstractCategoryAdapter;
use App\Sources\TransformedCategory;

class CategoryAdapter extends AbstractCategoryAdapter
{
    /**
     * Get the categories data from NewsAPI ORG
     * Then save them to database
     * @return bool
     * @throws \Exception
     */
    public function createOrUpdateCategories()
    {
        $categories = $this->client->dataServices->getCategories();
        foreach($categories as $data) {
            $transformedCategories = new TransformedCategory($data, ucwords($data));
            $saveCategory = $transformedCategories->createOrUpdateCategory($this->source);
            if (!$saveCategory) {
                throw new \Exception('Failed to save categories data from News API Org');
            }
        }
        return true;
    }
}