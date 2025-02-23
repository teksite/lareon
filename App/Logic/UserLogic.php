<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Lareon\CMS\App\Models\User;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class UserLogic
{
    public function getAll(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(User::class, ['title', 'phone', 'email'], ...$fetchData);
        });
    }

    public function register(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            $input['slug'] = strtolower(Str::random(3)) . time();
            $user = User::query()->create($input);
            $user->assignRole('user');
            return $user;
        });
    }

    public function change(array $input, User $user)
    {
        return app(ServiceWrapper::class)(function () use ($input, $user) {
            if (is_null($input['password'])) unset($input['password']);
            $user->update(Arr::except($input, 'meta'));
//            $user->meta()->updateOrCreate(
//                ['key' => 'info',],
//                ['value' => $input['meta']['info'] ?? [],],
//            );
            return $user;
        });
    }

    public function delete(User $user)
    {
        return app(ServiceWrapper::class)(function () use ($user) {
            $user->delete();

        });
    }

    public function getInfo(User $user)
    {
        return app(ServiceWrapper::class)(function () use ($user) {
            return $user->info();
        });
    }
}
