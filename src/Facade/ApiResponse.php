<?php

namespace Teksite\Lareon\Facade;

use Illuminate\Support\Facades\Facade;
use Teksite\Handler\Actions\ServiceResult;

/**
 * @method static WebResponse byResult(ServiceResult $result, ?string $success_route = null, ?string $success_message = null, ?string $failed_route = null, ?string $failed_message = null): static
 * @method static WebResponse go(): static
 *
 * @see \Teksite\Lareon\Services\Builder\WebResponse
 */
class ApiResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ApiResponse';
    }

}
