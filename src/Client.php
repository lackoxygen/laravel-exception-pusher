<?php

namespace Lackoxygen\ExceptionPush;

use GuzzleHttp\RequestOptions;

class Client
{
    protected \GuzzleHttp\Client $engine;

    public static function new($baseUri): Client
    {
        return new static($baseUri);
    }

    public function __construct(string $baseUri)
    {
        $this->engine = new \GuzzleHttp\Client([
            'base_uri' => $baseUri, RequestOptions::TIMEOUT => ExceptionPush::config('client.timeout', 30),
            RequestOptions::VERIFY => false
        ]);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->engine, $name], $arguments);
    }
}
