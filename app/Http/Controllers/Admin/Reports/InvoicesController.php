<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\Invoice\SearchRequest;
use App\Models\Invoices;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class InvoicesController extends Controller
{
    public function index()
    {
        return view('admin.reports.invoices');
    }
    public function searchInvoices(SearchRequest $request): View|RedirectResponse
    {
        $attributes = $request->validated();
        $rdio = $request->input('rdio');

        if ($rdio == 1) {
            $result = $this->handleTypeSearch($attributes);
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $invoices = $result;
        } else {
            $result = $this->handleInvoiceNumberSearch($attributes);
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $invoices = $result;
        }

        return view('admin.reports.invoices', compact('invoices'));
    }

    private function handleTypeSearch(array $attributes)
    {
        if (!isset($attributes['type'])) {
            return redirect()->back()->with('error', 'نوع الفاتورة مطلوب');
        }

        $query = Invoices::where('status', $attributes['type']);
        $this->applyDateFilters($query, $attributes);

        return $query->get();
    }

    private function handleInvoiceNumberSearch(array $attributes)
    {
        if (!isset($attributes['invoice_number'])) {
            return redirect()->back()->with('error', 'رقم الفاتورة مطلوب');
        }
        return Invoices::where('invoice_number', $attributes['invoiceNumber'])->get();
    }

    private function applyDateFilters($query, array $attributes): void
    {
        if (!empty($attributes['start_at']) && !empty($attributes['end_at'])) {
            $query->whereBetween('invoice_date', [$attributes['start_at'], $attributes['end_at']]);
        } elseif (!empty($attributes['start_at'])) {
            $query->where('invoice_date', '>=', $attributes['start_at']);
        } elseif (!empty($attributes['end_at'])) {
            $query->where('invoice_date', '<=', $attributes['end_at']);
        }
    }
}
