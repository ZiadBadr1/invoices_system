<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'roles_name' => ['required'],
            'status' => ['boolean'],
            'avatar' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'email.max' => 'يجب ألا يزيد البريد الإلكتروني عن 254 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مسجل بالفعل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل.',
            'roles_name.required' => 'اسم الصلاحية مطلوب.',
            'status.boolean' => 'يجب أن تكون الحالة صحيحة أو خاطئة.',
            'avatar.nullable' => 'الصورة الرمزية اختيارية.',
        ];
    }
}
