<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;


enum InvoiceStatus : int
{
    case UNPAID = 0;
    case PAID = 1;
    case PARTIALLY_PAID = 2;

    public static function getDescription(self $status): string
    {
        return match($status) {
            self::PAID => 'مدفوعة',
            self::PARTIALLY_PAID => 'مدفوعة جزئيا',
            self::UNPAID => 'غير مدفوعة',
        };
    }

    public static function getColor(self $status): string
    {
        return match($status) {
            self::PAID => 'green',
            self::PARTIALLY_PAID => 'orange',
            self::UNPAID => 'red',
        };
    }

    public static function getOptions(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'description' => self::getDescription($case)
        ], self::cases());
    }
}