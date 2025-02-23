<?php

namespace Lareon\CMS\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
        return array_merge($this->assignRules(), [
            'password' => 'nullable',
            'meta' => 'array',
        ]);
    }

    protected function assignRules() :array
    {
        $can = auth()->check() && auth()->user()->hasRole(['admin', 'administrator']);
        $defaultRules = User::rules();
        if ($can) {
           return array_merge($defaultRules, [
                'phone' => ['required', 'string', '', Rule::unique('users', 'phone')->ignore($this->user->id)],
                'email' => ['required', 'string', '', Rule::unique('users', 'email')->ignore($this->user->id)],
            ]);
        } else {
            unset($defaultRules['email'], $defaultRules['phone']);
            return $defaultRules;
        }
    }
}
