<?php

namespace App\Interfaces;

interface SourceInterface
{
    /**
     * List of sources
     * 
     * @return Collection
     */
    public function listSources();
}