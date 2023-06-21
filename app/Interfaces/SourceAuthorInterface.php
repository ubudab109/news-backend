<?php

namespace App\Interfaces;

interface SourceAuthorInterface
{
    /**
     * Create or update authors from each sources
     * 
     * @throws \Exception
     */
    public function createOrUpdateAuthors();
}