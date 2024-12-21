<?php

namespace App\Enums;

enum PaymentEnum: int
{
    case Cash = 0;
    case Card = 1;

    public function label(): string
    {
        return match ($this) {
            self::Cash => 'Наличные',
            self::Card => 'Банковская карта'
        };
    }
}
