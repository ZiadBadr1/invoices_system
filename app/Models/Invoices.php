<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use softDeletes;
    protected $fillable = [
        'invoice_number', 'invoice_date', 'due_date', 'section_id', 'product_id',
        'amount_collection', 'amount_commission', 'discount', 'value_VAT',
        'rate_VAT', 'total', 'status', 'note', 'payment_date', 'attachment'
    ];

    public function section():BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function details():HasMany
    {
        return $this->hasMany(InvoicesDetail::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(InvoicesAttachment::class);
    }


//    protected $casts = [
//        'status' => 'integer',
//    ];
//
//    public function getStatusDescriptionAttribute(): string
//    {
//        return InvoiceStatus::getDescription(InvoiceStatus::from($this->status));
//    }
//
//    public function getStatusColorAttribute(): string
//    {
//        return InvoiceStatus::getColor(InvoiceStatus::from($this->status));
//    }
}
