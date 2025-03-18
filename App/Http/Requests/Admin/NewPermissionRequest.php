<?php
namespace Lareon\CMS\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Teksite\Authorize\Models\Permission;
use Teksite\Authorize\Models\Role;

class NewPermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.permission.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Permission::rules();
    }
}
