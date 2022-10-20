<?php

namespace Lackoxygen\ExceptionPush\Contracts;

interface AgentInterface
{
    public function report(array $content);

    public function disabled(): bool;
}
