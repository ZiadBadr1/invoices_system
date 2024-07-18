<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicesAttachment extends Model
{
    protected $fillable= ['file_name', 'file_path', 'invoices_id', 'user_id'];

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoices::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
