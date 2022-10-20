<?php

namespace Lackoxygen\ExceptionPush;

use Carbon\Carbon;
use Lackoxygen\ExceptionPush\Attribute\Context;
use Lackoxygen\ExceptionPush\Contracts\CallbackInterface;

class Formatter implements CallbackInterface
{
    /**
     * @return \Closure
     */
    public function default(): \Closure
    {
        return function (Context $context) {
            return [
                '时间:' . Carbon::now()->toDateTimeString(), '环境:' . config('app.env'), '项目:' . config('app.name'),
                '参数:' . json_encode($context->getInput()), 'runtime:' . php_sapi_name(), '地址:' . $context->getPath(),
                '请求方法:' . $context->getMethod(), 'IP:' . $context->getIp(),
                '异常:' . sprintf(
                    '%s(%s)(code:%d)：at %s:%d',
                    $context->getException(),
                    $context->getMessage(),
                    $context->getCode(),
                    $context->getFile(),
                    $context->getLine()
                ),
                'trace:' . implode(PHP_EOL, $context->getTrace()),
            ];
        };
    }

    /**
     * @return \Closure|null
     */
    public function config(): ?\Closure
    {
        return closure(ExceptionPush::config('callbacks.formatter'));
    }


    /**
     * @return \Closure
     */
    public static function callback(): \Closure
    {
        $that = new static();

        if ($formatter = $that->config()) {
            return $formatter;
        }

        return $that->default();
    }
}
