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

    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'id' => $case->value,
            'label' => $case->label()
        ], self::cases());
    }
}
