<?php

namespace Lackoxygen\ExceptionPush\Handler;

use Illuminate\Support\Arr;
use Lackoxygen\ExceptionPush\Dispatcher;
use Lackoxygen\ExceptionPush\ExceptionPush;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractSyslogHandler;
use Monolog\Logger;

/**
 *    'papertrail' => [
 *          'driver' => 'monolog',
 *          'level' => env('LOG_LEVEL', 'debug'),
 *          'handler' => SyslogUdpHandler::class,
 *          'handler_with' => [
 *              'channels' => [Wx::class, Ding::class]
 *          ],
 *  ],
 */
class MonologHandler extends AbstractSyslogHandler
{
    /**
     * @var \Closure
     */
    protected \Closure $dispatcher;

    /**
     * @var array
     */
    protected array $channels = [];

    /**
     * @param array $channels
     * @param $facility
     * @param $level
     * @param bool $bubble
     */
    public function __construct(
        array $channels,
        $facility = LOG_USER,
        $level = Logger::DEBUG,
        bool  $bubble = true
    ) {
        parent::__construct($facility, $level, $bubble);

        $this->dispatcher = Dispatcher::callback();

        $this->channels = $channels;
    }

    /**
     * @param array $record
     *
     * @return void
     */
    protected function write(array $record): void
    {
        $agents = Arr::only(ExceptionPush::config('agents'), $this->channels);

        $callback = $this->dispatcher;

        $callback(ExceptionPush::getAgents($agents), [$record['formatted'] ?? '']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter('%channel%.%level_name%: %message% %context% %extra%');
    }
}
