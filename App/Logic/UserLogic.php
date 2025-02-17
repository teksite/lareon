<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Models\User;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class UserLogic
{
    public function getAll(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(User::class, ['title' ,'phone', 'email'], ...$fetchData);
        });
    }

    public function register(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            return User::query()->create($input);
        });
    }

    public function change(array $input, User $user)
    {
        return app(ServiceWrapper::class)(function () use ($input, $user) {
            $user->update($input, ['permissions']);
            return $user;
        });
    }

    public function delete(User $user)
    {
        return app(ServiceWrapper::class)(function () use ($user) {
            $user->delete();

        });
    }
}
