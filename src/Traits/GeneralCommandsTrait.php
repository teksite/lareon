<?php

namespace Teksite\Lareon\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Teksite\Lareon\Facade\Lareon;
use Teksite\Lareon\Services\LareonServices;

trait GeneralCommandsTrait
{

    public function print(\Closure $callback , string $message )
    {
        $startTime = Carbon::now();

        $callback();

        $endTime = Carbon::now();

        $executionTime = $startTime->diffInMilliseconds($endTime);

        $this->components->twoColumnDetail("$message" ,"$executionTime <fg=green;options=bold>DONE</>" );

    }
}
