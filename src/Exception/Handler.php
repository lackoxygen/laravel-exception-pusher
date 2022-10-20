<?php

namespace Lackoxygen\ExceptionPush\Exception;

use App\Exceptions\Handler as BaseHandler;
use Throwable;

class Handler extends BaseHandler
{
    /**
     * @param Throwable $e
     *
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        $this->beforeReport($e);

        $this->afterReport($e);
    }

    /**
     * @throws Throwable
     */
    private function beforeReport(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * @param Throwable $e
     *
     * @return void
     */
    private function afterReport(Throwable $e)
    {
        if ($this->shouldReport($e)) {
            app('exception.push')->report($e);
        }
    }
}
