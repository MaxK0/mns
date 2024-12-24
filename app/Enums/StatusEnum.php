<?php

namespace App\Enums;

enum StatusEnum: int
{
    case New = 0;
    case InProgress = 1;
    case Done = 2;
    case Cancelled = 3;

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новое',
            self::InProgress => 'В работе',
            self::Done => 'Выполнено',
            self::Cancelled => 'Отменено'
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
