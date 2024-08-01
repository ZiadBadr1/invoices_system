<?php

namespace App\Http\Requests\Reports\Invoice;

use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rdio' => ['required','integer'],
            'type' => ['sometimes', new Enum(InvoiceStatus::class)],
            'invoice_number' => ['nullable', 'string'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
            'rdio.required' => 'نوع البحث مطلوب.',
            'type.integer' => 'نوع الفاتورة يجب أن يكون رقميا.',
            'type.sometimes' => 'نوع الفاتورة مطلوب في بعض الأحيان.',
            'type.enum' => 'نوع الفاتورة غير صالح.',
            'invoice_number.sometimes' => 'رقم الفاتورة مطلوب في بعض الأحيان.',
            'invoice_number.string' => 'رقم الفاتورة يجب أن يكون نصياً.',
            'start_at.sometimes' => 'تاريخ البدء مطلوب في بعض الأحيان.',
            'start_at.date' => 'تاريخ البدء يجب أن يكون تاريخاً صالحاً.',
            'end_at.sometimes' => 'تاريخ الانتهاء مطلوب في بعض الأحيان.',
            'end_at.date' => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً.',
        ];
    }
}
