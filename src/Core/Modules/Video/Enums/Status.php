<?php

namespace Costa\Core\Modules\Video\Enums;


enum Status: int
{
    case PROCESSING = 1;
    case COMPLETE = 2;
    case PENDING = 3;

    public static function toArray(): array
    {
        return array_map(
            fn (self $type) => $type->value,
            self::cases()
        );
    }
}
