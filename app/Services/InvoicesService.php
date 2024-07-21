<?php

namespace App\Services;

use App\Actions\Images\StoreImageAction;
use App\Enums\InvoiceStatus;
use App\Models\Invoices;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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


    /**
     * @throws Exception
     */
    public function update(array $attributes, Invoices $invoice):Invoices
    {
        DB::beginTransaction();
        try {
            $attributes['user_id'] = auth()->id();

            $invoice->update($attributes);

            $detailsData = $this->getInvoiceDetail($attributes,$invoice);


            $invoice->details()->create($detailsData);

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
            'user_id' => $attributes['user_id'] ?? auth()->id(),
            'invoice_id' => $invoice->id ?? null,
            'section_id' => $attributes['section_id']?? $invoice->section_id ,
            'product_id' => $attributes['product_id']?? $invoice->product_id ,
            'status' => $attributes['status'] ?? InvoiceStatus::UNPAID->value,
            'payment_date' => $attributes['payment_date'] ?? null,
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

    public function forceDelete($id):bool
    {
        $invoice = Invoices::where('id', $id)->first();

        if ($invoice) {
            $invoiceNumber = $invoice->invoice_number;

            $folderPath = 'public/invoice/' . $invoiceNumber;

            if (Storage::exists($folderPath)) {
                Storage::deleteDirectory($folderPath);
            }

            $invoice->forceDelete();

            return true;
        }

        return false;
    }

}