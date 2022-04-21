<?php

namespace Costa\Core\CastMember\UseCases\DTO\Created;

use Costa\Core\CastMember\Enums\CastMemberType;

class Input
{
    public function __construct(
        public string $name,
        public CastMemberType $type,
        public bool $isActive = true,
        public string $createdAt = '',
    ) {
        //
    }
}
