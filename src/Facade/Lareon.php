<?php

namespace Teksite\Lareon\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string cmsPath(?string $path = null, bool $absolute = true)
 * @method static string cmsNamespace(?string $path = null)
 * @method static array getModules()
 *
 * @see \Teksite\Module\Services\LareonServices
 */
class Lareon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Lareon';
    }

}
