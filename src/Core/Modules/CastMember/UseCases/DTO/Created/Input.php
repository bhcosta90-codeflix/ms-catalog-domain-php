<?php

namespace Costa\Core\Modules\CastMember\UseCases\DTO\Created;

use Costa\Core\Modules\CastMember\Enums\CastMemberType;

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
