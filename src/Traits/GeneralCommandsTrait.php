<?php

namespace Teksite\Lareon\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Teksite\Lareon\Facade\Lareon;
use Teksite\Lareon\Services\LareonServices;

trait GeneralCommandsTrait
{

    public function print(\Closure $callback , $message )
    {
        $startTime = Carbon::now();

        $callback();

        $endTime = Carbon::now();

        $executionTime = $startTime->diffInMilliseconds($endTime); // محاسبه زمان اجرا
        $this->line(sprintf('%s ................................................................................................ %dms DONE', $message, $executionTime));
    }
}
