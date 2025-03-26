<?php

namespace Lareon\CMS\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Lareon\CMS\App\Models\User;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.user.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return collect(User::rules())->merge([
            'password' => 'nullable|string',
            'meta' => 'array',
            'email_verified' => 'sometimes',
            'phone_verified' => 'sometimes',
            'roles' => 'array|required',
            'roles.*' => 'exists:auth_roles,id',
            'permissions' => 'array|sometimes',
            'permissions.*' => 'exists:auth_permissions,id',
        ])->filter(function ($item, $key) {
            if (auth()->user()->hasRole(['admin', 'administrator', 'owner'])) {
                return !in_array($key, ['email', 'phone']);
            }
            return true;
        })->toArray();
    }
}
