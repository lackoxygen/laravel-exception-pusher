<?php

namespace Lackoxygen\ExceptionPush\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Lackoxygen\ExceptionPush\Dispatcher;

class ExceptionPushJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    protected array $agents;

    protected array $traces;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $agents, array $traces)
    {
        $this->agents = $agents;

        $this->traces = $traces;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dispatcher = new Dispatcher();

        $callback = $dispatcher->default();

        $callback($this->agents, $this->traces);
    }

    public static function push()
    {
        static::dispatch(...func_get_args());
    }
}
