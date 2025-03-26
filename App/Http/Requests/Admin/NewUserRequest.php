<?php
namespace Lareon\CMS\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Lareon\CMS\App\Models\User;

class NewUserRequest extends FormRequest
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
        return array_merge(User::rules() ,[
            'sendNotification' => ['sometimes'],
            'password' => 'sometimes|required|min:8|confirmed',
        ]);
    }
}
