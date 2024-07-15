<?php

namespace App\Http\Requests\Section;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','unique:sections,name,'. $this->id],
            'description' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم القسم مطلوب.',
            'name.unique' => 'اسم القسم موجود بالفعل.',
        ];
    }
}
