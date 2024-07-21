<?php

namespace App\Services;

use App\Models\Invoices;
use Illuminate\Support\Facades\Storage;

class TrashedInvoicesService
{

    public function restore($id):bool
    {
        $invoice = Invoices::onlyTrashed()->where('id', $id)->first();

        if ($invoice) {
            $invoice->restore();

            return true;
        }

        return false;
    }
    public function forceDelete($id):bool
    {
        $invoice = Invoices::onlyTrashed()->where('id', $id)->first();

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