<?php

namespace App\Sources\TheGuardian;

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
            'base_uri' => 'https://content.guardianapis.com/'
        ]);
    }
}