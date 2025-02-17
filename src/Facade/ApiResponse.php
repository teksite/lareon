<?php

namespace Teksite\Lareon\Facade;

use Illuminate\Support\Facades\Facade;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Lareon\Services\Builder\JsonResponse;

/**
 * @method static JsonResponse byResult(ServiceResult $result, ?string $success_message = null, ?string $failed_message = null , int|string $status = 200): static
 * @method static JsonResponse reply(): static
 *
 * @see JsonResponse
 */
class ApiResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ApiResponse';
    }

}
