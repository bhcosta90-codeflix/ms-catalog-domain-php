<?php

namespace Costa\Core\Modules\CastMember\Enums;


enum CastMemberType: int
{
    case DIRECTOR = 1;
    case ACTOR = 2;

    public static function toArray(): array
    {
        return array_map(
            fn (self $type) => $type->value,
            self::cases()
        );
    }
}
