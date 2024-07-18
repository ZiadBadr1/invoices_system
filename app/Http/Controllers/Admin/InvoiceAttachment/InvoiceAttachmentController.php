<?php

namespace App\Http\Controllers\Admin\InvoiceAttachment;

use App\Actions\Images\DeleteImageAction;
use App\Actions\Images\StoreImageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceAttachment\StoreRequest;
use App\Models\InvoicesAttachment;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{

    public function __construct(protected DeleteImageAction $deleteImageAction)
    {}

    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = auth()->id();
        $attributes['file_name'] = $attributes['attachment']->getClientOriginalName();
        $attributes['file_path'] = (new StoreImageAction())->execute($attributes['attachment'],"invoice/{$attributes['invoice_number']}");

        InvoicesAttachment::create($attributes);
        return redirect()->back()->with('success', 'تم إضافة الملف بنجاح');

    }

    public function view(InvoicesAttachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->file_path)) {
            return response()->file(storage_path("app/public/$attachment->file_path"));
        }
        return redirect()->route('admin.invoices.show',$attachment->invoices_id)->with('error', 'غير قادر علي فتح هذا الملف');
    }

    public function download(InvoicesAttachment $attachment)
    {
        if (Storage::disk('public')->exists($attachment->file_path)) {
            return Storage::disk('public')->download($attachment->file_path);
        }
        return redirect()->route('admin.invoices.show',$attachment->invoices_id)->with('error', 'غير قادر علي تحميل هذا الملف');
    }

    public function delete(InvoicesAttachment $attachment)
    {

        if (Storage::disk('public')->exists($attachment->file_path)) {
            $this->deleteImageAction->execute($attachment->file_path);
            $attachment->delete();
            return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
        }
        return redirect()->back()->with('error', 'غير قادر علي إيجاد هذا الملف');

    }
}
