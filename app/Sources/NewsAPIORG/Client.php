<?php

namespace App\Sources\NewsAPIORG;

use App\Sources\AbstractClient;
use jcobhams\NewsApi\NewsApi;

class Client extends AbstractClient
{
    /** @var NewsApi */
    public $dataServices;
    /**
     * Client constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct([
            'base_uri' => 'https://newsapi.org/v2/',
        ]);
        $this->dataServices = new NewsApi(config('app.news_api_org_key'));
    }
}