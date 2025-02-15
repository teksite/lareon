<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Spatie\ResponseCache\Facades\ResponseCache;
use Teksite\Handler\Actions\ServiceWrapper;

class CachesLogic
{
    public function getAll()
    {
        return [
            'cache'=>['store'=>false , 'destroy'=>true],
            'view'=>['store'=>true , 'destroy'=>true],
            'config'=>['store'=>true , 'destroy'=>true],
            'route'=>['store'=>true , 'destroy'=>true],
            'event'=>['store'=>false , 'destroy'=>true],
            'optimize'=>['store'=>false , 'destroy'=>true],
            'response'=>['store'=>false , 'destroy'=>true],
            'app'=>['store'=>true , 'destroy'=>true],
        ];
    }

    public function save(string $type)
    {
        return app(ServiceWrapper::class)(fn() => Artisan::call($type . ":cache"),hasTransaction:false);

    }

    public function clear(string $type)
    {
        if (in_array($type, ['cache', 'view', 'config', 'route', 'event','optimize','app'])) {
            return app(ServiceWrapper::class)(fn() => Artisan::call($type . ":clear") ,hasTransaction:false);
        }

        if($type ==='response'){
           // return app(ServiceWrapper::class)(fn() => ResponseCache::clear() ,hasTransaction:false);
        }
    }
}

