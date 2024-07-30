<?php

namespace App\Http\Requests\roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $roleId = $this->route('role');
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الصلاحية مطلوب.',
            'name.unique' => 'اسم الصلاحية مأخوذ بالفعل.',
            'permission.required' => 'مطلوب تحديد صلاحية واحدة على الأقل.',
            'permission.*.exists' => 'واحدة أو أكثر من الصلاحيات المحددة غير صالحة.',
        ];
    }
}
