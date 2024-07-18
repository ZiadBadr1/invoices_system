<?php

namespace App\Http\Requests\InvoiceAttachment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attachment' => ['required', 'file', 'mimes:pdf,jpg,png,jpeg'],
            'invoices_id' => ['required', 'exists:invoices,id'],
            'invoice_number' => ['required', 'exists:invoices,invoice_number'],
        ];
    }

    public function messages(): array
    {
        return [
            'attachment.required' => 'حقل المرفق مطلوب.',
            'attachment.file' => 'يجب أن يكون المرفق ملفاً.',
            'attachment.mimes' => 'يجب أن يكون المرفق بواحدة من الصيغ التالية: pdf, jpg, png, jpeg.',
            'invoices_id.required' => 'حقل رقم الفاتورة مطلوب.',
            'invoices_id.exists' => 'رقم الفاتورة غير موجود.',
            'invoice_number.required' => 'حقل رقم الفاتورة مطلوب.',
            'invoice_number.exists' => 'رقم الفاتورة غير موجود.',
        ];
    }
}
