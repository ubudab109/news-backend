<?php

namespace App\Sources\NewsApiAI;

use App\Sources\AbstractClient;

class Client extends AbstractClient
{
    /**
     * Client constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct([
            'base_uri' => 'https://newsapi.ai/api/v1/',
        ]);
    }
}