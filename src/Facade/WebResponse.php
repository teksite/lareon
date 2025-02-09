<?php

namespace Teksite\Lareon\Facade;

use Illuminate\Support\Facades\Facade;
use Teksite\Handler\Actions\ServiceResult;

/**
 * @method static WebResponse byResult(ServiceResult $result, $success = ['route' => null, 'message' => null], $failed = ['route' => null, 'message' => null]): static
 * @method static WebResponse go(): static
 *
 * @see \Teksite\Lareon\Services\Builder\WebResponse
 */
class WebResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'WebResponse';
    }

}
