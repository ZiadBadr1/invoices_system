<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicesDetail extends Model
{
    protected $fillable = [
        'invoices_id', 'user_id', 'section_id', 'product_id', 'status',
        'payment_date', 'note'
    ];

    public function invoices():BelongsTo
    {
       return $this->belongsTo(Invoices::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function section():BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
