<?php

namespace App\Actions\Search;

class TimeSearchAction
{
    public function execute($query, array $attributes): void
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