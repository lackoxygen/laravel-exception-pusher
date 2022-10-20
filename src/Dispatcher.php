<?php

namespace Lackoxygen\ExceptionPush;

use Lackoxygen\ExceptionPush\Contracts\AgentInterface;
use Lackoxygen\ExceptionPush\Contracts\CallbackInterface;

class Dispatcher implements CallbackInterface
{
    /**
     * @return \Closure|null
     */
    public function config(): ?\Closure
    {
        return closure(ExceptionPush::config('callbacks.dispatcher'));
    }

    /**
     * @return \Closure
     */
    public function default(): \Closure
    {
        return function ($agents, $body) {
            foreach ($agents as $agent) {
                if (!$agent instanceof AgentInterface) {
                    continue;
                }
                if ($agent->disabled()) {
                    continue;
                }
                try {
                    $agent->report($body);
                } catch (\Throwable $exception) {
                }
            }
        };
    }

    /**
     * @return \Closure
     */
    public static function callback(): \Closure
    {
        $that = new static();

        if ($dispatcher = $that->config()) {
            return $dispatcher;
        }

        return $that->default();
    }
}
