<?php

namespace App\Http\Requests\Invoices;

use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invoice_number' => ['required'],
            'invoice_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'section_id' => ['required', 'integer','exists:sections,id'],
            'product_id' => ['required', 'integer','exists:products,id'],
            'amount_collection' => ['required', 'numeric'],
            'amount_commission' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'value_VAT' => ['required', 'numeric'],
            'rate_VAT' => ['required'],
            'total' => ['required', 'numeric'],
            'status' => ['nullable', new Enum(InvoiceStatus::class)],
            'note' => ['nullable'],
            'payment_date' => ['nullable', 'date'],        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'integer' => 'حقل :attribute يجب أن يكون رقمًا صحيحًا.',
            'numeric' => 'حقل :attribute يجب أن يكون رقمًا.',
            'date' => 'حقل :attribute يجب أن يكون تاريخًا صحيحًا.',
            'exists' => 'حقل :attribute غير موجود.',
        ];
    }

    public function attributes(): array
    {
        return [
            'invoice_number' => 'رقم الفاتورة',
            'invoice_date' => 'تاريخ الفاتورة',
            'due_date' => 'تاريخ الاستحقاق',
            'section_id' => 'القسم',
            'product_id' => 'المنتج',
            'amount_collection' => 'مبلغ التحصيل',
            'amount_commission' => 'مبلغ العمولة',
            'discount' => 'الخصم',
            'value_VAT' => 'قيمة ضريبة القيمة المضافة',
            'rate_VAT' => 'نسبة ضريبة القيمة المضافة',
            'total' => 'آلإجمالي شامل الضريبة',
            'status' => 'الحالة',
            'note' => 'ملاحظات',
        ];
    }
}
