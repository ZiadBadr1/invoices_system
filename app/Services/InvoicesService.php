<?php

namespace App\Services;

use App\Actions\Images\StoreImageAction;
use App\Enums\InvoiceStatus;
use App\Models\Invoices;
use Exception;
use Illuminate\Support\Facades\DB;

class InvoicesService
{
    public function __construct(protected StoreImageAction $storeImageAction)
    {}

    /**
     * @throws Exception
     */
    public function store(array $attributes):Invoices
    {
        DB::beginTransaction();
        try {
            $attributes['status'] = InvoiceStatus::UNPAID->value;
            $attributes['user_id'] = auth()->id();

            if (isset($attributes['attachment'])) {
                $attachment = $attributes['attachment'];
                $attributes['attachment_name'] = $attachment->getClientOriginalName();
                $attachmentData = $this->storeImageAction->execute($attachment, "invoice/{$attributes['invoice_number']}");
                $attributes['attachment_path'] = $attachmentData;
            }

            $invoice = Invoices::create($attributes);

            $detailsData = $this->getInvoiceDetail($attributes,$invoice);


                $invoice->details()->create($detailsData);


            $attachmentsData = $this->getInvoiceAttachment($attributes, $invoice);
                $invoice->attachments()->create($attachmentsData);


            DB::commit();

            return $invoice;

        }catch (Exception $e){}
        {
            DB::rollBack();
            throw $e;
        }
    }

    private function getInvoiceDetail(array $attributes,$invoice): array
    {
        return [
            'user_id' => $attributes['user_id'],
            'invoice_id' => $invoice->id,
            'section_id' => $attributes['section_id'],
            'product_id' => $attributes['product_id'],
            'status' => InvoiceStatus::UNPAID->value,
            'payment_date' => null,
            'note' => $attributes['note'] ?? null,
        ];
    }

    private function getInvoiceAttachment(array $attributes,$invoice): array
    {
        return [
            'invoice_id' => $invoice->id,
            'file_name' => $attributes['attachment_name'],
            'file_path' => $attributes['attachment_path'],
            'user_id' => $attributes['user_id'],
        ];
    }

}