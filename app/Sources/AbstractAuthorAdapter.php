<?php

namespace App\Sources;

use App\Factories\ClientFactory;
use App\Interfaces\SourceAuthorInterface;
use App\Models\Author;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class AbstractAuthorAdapter implements SourceAuthorInterface 
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
     * Handles creating or updating the authors data
     * 
     * @param TransformedAuthor $transformedAuthor
     * @return Author|void|null
     */
    public function handleAuthors(TransformedAuthor $transformedAuthor)
    {
        $createdAuthor = null;
        DB::transaction(function () use (&$transformedAuthor, &$createdAuthor) {
            $transformedAuthor = $transformedAuthor->createOrUpdateAuthor($this->source);
            $createdAuthor = $transformedAuthor->fresh();
        }, 3);

        if (!$createdAuthor) {
            Log::channel('test')->info('There is an error when transformed the author');
        }

        return $createdAuthor;
    }

}