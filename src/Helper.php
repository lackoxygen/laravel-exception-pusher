<?php

namespace Lackoxygen\ExceptionPush;

use Lackoxygen\ExceptionPush\Agents\Ding;
use Lackoxygen\ExceptionPush\Agents\Wx;
use Lackoxygen\ExceptionPush\Handler\MonologHandler;
use Monolog\Logger;

if (!function_exists('closure')) {
    function closure($closure): ?\Closure
    {
        if (is_array($closure) && 2 === count($closure)) {
            [$class, $method] = $closure;

            return function () use ($class, $method) {
                $handler = new $class();

                return call_user_func_array([$handler, $method], func_get_args());
            };
        }

        if (is_string($closure)) {
            return function () use ($closure) {
                return call_user_func($closure, ...func_get_args());
            };
        }

        return $closure instanceof \Closure ? $closure : null;
    }
}


if (!function_exists('notify')) {
    function notify($message, $label = 'info')
    {
        $log = new Logger('notify');
        $log->pushHandler(new MonologHandler([Ding::class, Wx::class]));
        $log->{$label}($message);
    }
}
