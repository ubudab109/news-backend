<?php

namespace App\Sources;

use App\Interfaces\SourceCategoryInterface;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class AbstractCategoryAdapter implements SourceCategoryInterface 
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
        $this->client = $source->getClient();
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
     * Handles creating or updating the category data
     * 
     * @param TransformedCategory $transformedCategory
     * @return Category|void|null
     */
    public function handleCategory(TransformedCategory $transformedCategory)
    {
        $createdCategory = null;
        DB::transaction(function () use (&$transformedCategory, &$createdCategory) {
            $transformedCategory = $transformedCategory->createOrUpdateCategory($this->source);
            $createdCategory = $transformedCategory->fresh();
        }, 3);

        if (!$createdCategory) {
            Log::channel('test')->info('There is an error when transformed the aucategorythor');
        }

        return $createdCategory;
    }

}