<?php

namespace Lackoxygen\ExceptionPush\Contracts;

interface CallbackInterface
{
    public function default(): \Closure;

    public function config(): ?\Closure;

    public static function callback(): \Closure;
}
