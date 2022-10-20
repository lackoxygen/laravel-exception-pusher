<?php

namespace Lackoxygen\ExceptionPush\Attribute;

use Lackoxygen\ExceptionPush\Contracts\AgentInterface;

class Context
{
    private string $exception;

    private string $message;

    private array $input;

    private string $code;

    private string $line;

    private string $file;

    private array $trace;

    private string $path;

    private string $method;

    private string $ip;

    private array $extras = [];

    /**
     * @return string
     */
    public function getException(): string
    {
        return $this->exception;
    }

    /**
     * @param string $exception
     */
    public function setException(string $exception): void
    {
        $this->exception = $exception;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getLine(): string
    {
        return $this->line;
    }

    /**
     * @param string $line
     */
    public function setLine(string $line): void
    {
        $this->line = $line;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function getTrace(): array
    {
        return $this->trace;
    }

    /**
     * @param array $trace
     */
    public function setTrace(array $trace): void
    {
        $this->trace = $trace;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getAgents(): array
    {
        return $this->agents;
    }

    /**
     * @param AgentInterface $agent
     */
    public function pushAgent(AgentInterface $agent): void
    {
        $this->agents[] = $agent;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param array $input
     */
    public function setInput(array $input): void
    {
        $this->input = $input;
    }

    /**
     * @return array
     */
    public function getInput(): array
    {
        return $this->input;
    }

    /**
     * @param array $extras
     */
    public function setExtras(array $extras): void
    {
        $this->extras = $extras;
    }

    /**
     * @return array
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'exception' => $this->exception, 'message' => $this->message, 'ip' => $this->ip, 'code' => $this->code,
            'line' => $this->line, 'file' => $this->file, 'trace' => $this->trace, 'path' => $this->path,
            'method' => $this->method, 'agents' => $this->agents, 'input' => $this->input
        ];
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }
    }
}
