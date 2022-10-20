<?php

namespace Lackoxygen\ExceptionPush\Agents;

use GuzzleHttp\RequestOptions;
use Lackoxygen\ExceptionPush\Attribute\Attribute;
use Lackoxygen\ExceptionPush\Client;
use Lackoxygen\ExceptionPush\Contracts\AgentInterface;

class Wx implements AgentInterface
{
    use Attribute;

    public string $key = '';

    public bool $enable = true;

    public function report(array $content)
    {
        /**
         * @var \GuzzleHttp\Client $client
         */
        $client = Client::new('https://qyapi.weixin.qq.com');

        $client->post('cgi-bin/webhook/send', [
            RequestOptions::HEADERS => [
                'content-type' => 'application/json'
            ], RequestOptions::QUERY => [
                'key' => $this->key,
            ], RequestOptions::JSON => [
                'msgtype' => 'text', 'text' => [
                    'content' => join("\n", $content)
                ]
            ]
        ]);
    }

    public function disabled(): bool
    {
        return !$this->enable;
    }
}
