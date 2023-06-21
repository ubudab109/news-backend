<?php

namespace App\Services;

use App\Interfaces\AuthorInterface;

class AuthorService
{
    /** @var AuthorInterface */
    protected $author;

    /**
     * Constructor
     * @param AuthorInterface $author
     */
    public function __construct(AuthorInterface $author)
    {
        $this->author = $author;
    }

    /**
     * Get authors by selected sources
     * @param array $sources
     * @return array
     */
    public function getAuthorBySources(array $sources)
    {
        $data = $this->author->getAuthorBySource($sources);
        return [
            'success' => true,
            'message' => 'Data Authors fetched successfully',
            'data'    => $data,
        ];
    }
}