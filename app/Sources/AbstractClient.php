<?php

namespace App\Sources;

use App\Models\Source;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class AbstractClient extends Client implements ClientInterface
{
    /**
     * AbstractClient constructor.
     *
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        try {
            $guzzleConfig = array_merge(['http_errors' => false], $config);
            parent::__construct($guzzleConfig);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
