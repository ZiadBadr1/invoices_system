<?php

namespace App\Http\Controllers\Admin\TrashedInvoices;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Services\TrashedInvoicesService;
use Illuminate\Http\Request;

class TrashedInvoicesController extends Controller
{
    public function __construct(protected TrashedInvoicesService  $invoicesService)
    {}
    public function index()
    {
        return view('admin.invoice.trashed', [
            'invoices' => Invoices::onlyTrashed()->get(),
        ]);
    }

    public function restore($id)
    {
        $result = $this->invoicesService->restore($id);

        if ($result) {
            return redirect()->back()->with('success', 'تم استعادة الفاتورة بنجاح');
        }
        return redirect()->back()->with('error', 'الفاتورة غير موجودة');
    }

    public function forceDelete($id)
    {
        $result = $this->invoicesService->forceDelete($id);

        if ($result) {
            return redirect()->back()->with('success', 'تم حذف الفاتورة نهائيا بنجاح');
        }

        return redirect()->back()->with('error', 'الفاتورة غير موجودة');
    }
}
