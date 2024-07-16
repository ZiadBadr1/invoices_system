<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'section_id' => ['required', 'integer','exists:sections,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المنتج مطلوب.',
            'description.required' => 'الوصف مطلوب.',
            'section_id.required' => 'رقم القسم مطلوب.',
            'section_id.integer' => 'رقم القسم يجب أن يكون عددًا صحيحًا.',
            'section_id.exists' => 'القسم المحدد غير موجود.',
        ];
    }
}
