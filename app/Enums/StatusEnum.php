<?php

namespace App\Enums;

enum StatusEnum: int
{
    case New = 0;
    case Done = 1;
    case Cancelled = 2;

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новая заявка',
            self::Done => 'Услуга оказана',
            self::Cancelled => 'Услуга отменена'
        };
    }
}
