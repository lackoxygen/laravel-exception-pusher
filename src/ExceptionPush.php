<?php

namespace Lackoxygen\ExceptionPush;

use Illuminate\Support\Arr;

class ExceptionPush
{
    /**
     * @var Parser
     */
    protected Parser $parser;

    /**
     * @var array
     */
    protected array $agents;

    public function __construct()
    {
        $this->parser = new Parser();

        $this->agents = static::getAgents();
    }


    /**
     * @param $options
     *
     * @return array
     */
    public static function getAgents($options = null): array
    {
        $agentOpts = $options ?: (array)static::config('agents');

        $agents = [];

        foreach ($agentOpts as $agentName => $opts) {
            $agent = new $agentName();

            if (!is_array($opts)) {
                continue;
            }

            foreach ($opts as $key => $value) {
                $agent->{$key} = $value;
            }

            $agents[] = $agent;
        }

        return $agents;
    }


    /**
     * @param $key
     * @param $default
     *
     * @return array|\ArrayAccess|mixed
     */
    public static function config($key = null, $default = null)
    {
        $config = \config('exception.push');

        return Arr::get($config, $key, $default);
    }

    /**
     * @return void
     */
    public function report(\Throwable $e)
    {
        $this->parser->extract($e);

        $this->dispatch($this->format());
    }

    /**
     * @return array
     */
    protected function format(): array
    {
        $formatter = Formatter::callback();

        $body = $formatter($this->parser->context());


        if (!is_array($body)) {
            throw new \RuntimeException('Custom function must return array format');
        }

        return $body;
    }

    /**
     * @param array $body
     *
     * @return void
     */
    protected function dispatch(array $body)
    {
        $dispatcher = Dispatcher::callback();
        $dispatcher($this->agents, $body);
    }
}
