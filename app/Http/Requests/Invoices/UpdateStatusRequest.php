<?php

namespace App\Http\Requests\Invoices;

use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(InvoiceStatus::class)],
            'payment_date' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'status.required' => 'حقل حالة الدفع مطلوب.',
            'status.enum' => 'حقل حالة الدفع يحتوي على قيمة غير صحيحة.',
            'payment_date.required' => 'حقل تاريخ الدفع  مطلوب.',
            'payment_date.date' => 'حقل تاريخ الدفع يجب أن يكون تاريخاً صالحاً.',
        ];
    }
}
