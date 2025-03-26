<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Lareon\CMS\App\Events\UserRegistrationEvent;
use Lareon\CMS\App\Models\User;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class UserLogic
{
    /**
     * @param mixed $fetchData
     * @return ServiceResult
     */
    public function get(mixed $fetchData = []): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(User::class, ['name' ,'phone' , 'email'], ...$fetchData);
        });
    }

    /**
     * @param array $input
     * @return ServiceResult
     */
    public function register(array $input): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            $input['slug'] = strtolower(Str::random(6) . time());
            $input['parent_id'] = auth()->id();
            $user = User::query()->create(Arr::except($input, ['sendNotification']));
            $user->assignRole('user');
            if (isset($input['sendNotification'])) {
                event(new UserRegistrationEvent($user));
            }
            return $user;
        });
    }

    /**
     * @param array $input
     * @param User $user
     * @return ServiceResult
     */
    public function change(array $input, User $user): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($input, $user) {
            if (!isset($input['password']) || $input['password'] == null) unset($input['password']);
            $user->update(Arr::except($input, ['roles', 'permissions', 'meta']));

            if (isset($input['email_verified'])) $user->markEmailAsVerified();
            if (isset($input['phone_verified'])) $user->markPhoneAsVerified();

            $user->assignRole($input['roles']);
            $user->syncPermissions($input['permissions'] ?? []);

            return $user;
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

