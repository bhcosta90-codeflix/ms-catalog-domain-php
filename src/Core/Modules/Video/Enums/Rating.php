<?php

namespace Costa\Core\Modules\Video\Enums;


enum Rating: string
{
    case ER = 'ER';
    case L = 'L';
    case RATE10 = '10';
    case RATE12 = '12';
    case RATE14 = '14';
    case RATE16 = '16';
    case RATE18 = '18';

    public static function toArray(): array
    {
        return array_map(
            fn (self $type) => $type->value,
            self::cases()
        );
    }
}
