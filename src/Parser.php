<?php

namespace Lackoxygen\ExceptionPush;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lackoxygen\ExceptionPush\Attribute\Context;

class Parser
{
    protected \Throwable $throw;

    protected Context $context;

    protected Request $request;

    public function __construct()
    {
        $this->context = new Context();

        $this->request = app(Request::class);
    }

    /**
     * @return array
     */
    protected function simpleTrace(): array
    {
        return array_map(function ($line) {
            return $this->realpath($line);
        }, array_slice(explode(PHP_EOL, $this->throw->getTraceAsString()), 0, 4));
    }

    /**
     * @param string $line
     *
     * @return string
     */
    protected function realpath(string $line): string
    {
        return Str::replace(app()->basePath(), '', $line);
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public function extract(\Throwable $e): void
    {
        $this->throw = $e;

        $this->context->setException(get_class($this->throw));
        $this->context->setMethod($this->request->getMethod());
        $this->context->setPath($this->request->path());
        $this->context->setCode((string)$this->throw->getCode());
        $this->context->setFile($this->realpath($this->throw->getFile()));
        $this->context->setLine($this->throw->getLine());
        $this->context->setMessage($this->throw->getMessage());
        $this->context->setTrace($this->simpleTrace());
        $this->context->setInput($this->request->post());
        $this->context->setIp($this->request->ip());
    }

    /**
     * @return Context
     */
    public function context(): Context
    {
        return $this->context;
    }
}
