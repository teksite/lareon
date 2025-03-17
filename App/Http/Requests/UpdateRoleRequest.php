<?php
namespace Lareon\CMS\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Teksite\Authorize\Models\Role;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.role.edit')/* && !in_array($this->role->id , [1,2,3])*/;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(Role::rules() ,[
            'title' => ['required', 'string', 'max:255',Rule::unique('auth_roles')->ignore($this->role)],
        ]);
    }
}
