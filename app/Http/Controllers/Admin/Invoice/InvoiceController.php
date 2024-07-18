<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\StoreRequest;
use App\Models\Invoices;
use App\Models\Product;
use App\Models\Section;
use App\Services\InvoicesService;
use Exception;




class InvoiceController extends Controller
{
    public function __construct(protected InvoicesService  $invoicesService)
    {}

    public function index()
    {
        return view('admin.invoice.index',[
            'invoices' => Invoices::all()
        ]);
    }

    public function create()
    {
        return view('admin.invoice.create',[
            'sections' => Section::all(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();
        $this->invoicesService->store($attributes);
        return redirect()->route('admin.invoices.index')->with('success','تم إنشاء الفاتورة بنجاح');

    }

    public function show(Invoices $invoice)
    {
        return view('admin.invoice.show',[
            'invoices' => $invoice->load(['details','attachments']),
            'details' => $invoice->details(),
            'attachments' => $invoice->attachments(),
        ]);
    }
    public function getProducts($id)
    {
        $products = Product::where("section_id", $id)->pluck("name", "id");
        return json_encode($products);
    }
}
