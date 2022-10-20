<?php

namespace Lackoxygen\ExceptionPush;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Lackoxygen\ExceptionPush\Exception\Handler;

class ExceptionPushProvider extends ServiceProvider
{
    protected array $commands = [];

    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $configPath = __DIR__ . '/../publish/exception.push.php';
            $this->publishes([
                $configPath => config_path('exception.push.php')
            ], 'lackoxygen-exception-push');
        }
    }


    public function register()
    {
        $this->app->singleton(ExceptionHandler::class, Handler::class);
        $this->app->singleton('exception.push', ExceptionPush::class);
    }


    /**
     * @return string[]
     */
    public function provides(): array
    {
        return ['exception.push'];
    }
}
