<?php

namespace Lackoxygen\ExceptionPush\Agents;

use GuzzleHttp\Psr7\Request;
use Lackoxygen\ExceptionPush\Attribute\Attribute;
use Lackoxygen\ExceptionPush\Client;
use Lackoxygen\ExceptionPush\Contracts\AgentInterface;

class Ding implements AgentInterface
{
    use Attribute;

    public string $token = '';

    public string $secret = '';

    public bool $enable = true;

    public function report(array $content)
    {
        /**
         * @var \GuzzleHttp\Client $client
         */
        $client = Client::new('https://oapi.dingtalk.com');

        $uri = sprintf('robot/send?access_token=%s', $this->token);

        if (!empty($this->secret)) {
            $timestamp = time() . sprintf('%03d', rand(1, 999));
            $sign = hash_hmac('sha256', $timestamp . "\n" . $this->secret, $this->secret, true);
            $uri .= '&timestamp=' . $timestamp;
            $uri .= '&sign=' . base64_encode($sign);
        }

        $request = new Request(
            'POST',
            $uri,
            [
                'Content-Type' => 'application/json;charset=utf-8'
            ],
            $this->body($content),
            '1.1'
        );

        $client->send($request);
    }

    /**
     * @param array $content
     * @return string
     */
    protected function body(array $content): string
    {
        return json_encode([
            'msgtype' => 'text',
            'text' => [
                'content' => join("\n", $content)
            ],
            'isAtAll' => false
        ]);
    }

    /**
     * @return bool
     */
    public function disabled(): bool
    {
        return !$this->enable;
    }
}
