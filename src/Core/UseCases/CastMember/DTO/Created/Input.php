<?php

namespace Costa\Core\UseCases\CastMember\DTO\Created;

use Costa\Core\Domains\Enums\CastMemberType;

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
