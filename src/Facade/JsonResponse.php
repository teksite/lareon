<?php

namespace Teksite\Lareon\Facade;

use Illuminate\Support\Facades\Facade;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Lareon\Services\Builder\JsonResponse as Service;

/**
 * @method static Service byResult(ServiceResult $result, ?string $success_message = null, ?string $failed_message = null , int|string $status = 200): static
 * @method static Service reply(): static
 *
 * @see Service
 */
class JsonResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'JsonResponse';
    }

}
