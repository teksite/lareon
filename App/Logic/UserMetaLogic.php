<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Lareon\CMS\App\Events\UserRegistrationEvent;
use Lareon\CMS\App\Models\User;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class UserMetaLogic
{
    /**
     * @param User $user
     * @param array|string $keys
     * @param string[] $columns
     * @return ServiceResult
     */
    public function get(User $user, array|string $keys = '*', array|String $columns = ['*']): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($columns, $keys, $user) {
            return app(FetchDataService::class)(fn () => $user->getMeta($keys  , $columns));
        });
    }

    /**
     * @param User $user
     * @param array $input
     * @return ServiceResult
     */
    public function registerOrChange(User $user, array $input): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($user, $input) {
            $meta = [];
            foreach ($input as $key => $value) {
                $meta[] = $user->meta()->updateOrCreate([
                    'key' => $key,
                ], [
                    'value' => $value ?? null,
                ]);
            }

            return $meta;
        });
    }

    /**
     * @param User $user
     * @return ServiceResult
     */
    public function delete(User $user): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($user) {
            $user->delete();
        });
    }

}

