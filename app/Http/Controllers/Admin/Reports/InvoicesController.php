<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Actions\Search\TimeSearchAction;
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
        (new TimeSearchAction())->execute($query, $attributes);

        return $query->get();
    }

    private function handleInvoiceNumberSearch(array $attributes)
    {
        if (!isset($attributes['invoice_number'])) {
            return redirect()->back()->with('error', 'رقم الفاتورة مطلوب');
        }
        return Invoices::where('invoice_number', $attributes['invoice_number'])->get();
    }

}
