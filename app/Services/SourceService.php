<?php

namespace App\Services;

use App\Interfaces\SourceInterface;

class SourceService
{
    /** @var SourceInterface */
    protected $source;

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    /**
     * Get all sources data
     * 
     * @return array
     */
    public function listSources()
    {
        $data = $this->source->listSources();
        return [
            'success' => true,
            'message' => 'Data sources fetched successfully',
            'data'    => $data,
        ];
    }
}