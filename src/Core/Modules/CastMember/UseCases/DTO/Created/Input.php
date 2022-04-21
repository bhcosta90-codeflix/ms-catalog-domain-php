<?php

namespace Costa\Core\Modules\CastMember\UseCases\DTO\Created;

class Input
{
    public function __construct(
        public string $name,
        public int $type,
        public string $createdAt = '',
    ) {
        //
    }
}
