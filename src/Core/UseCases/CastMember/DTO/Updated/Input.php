<?php

namespace Costa\Core\UseCases\CastMember\DTO\Updated;

class Input
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $description = null,
        public ?bool $isActive = null,
        public string $createdAt = ''
    ) {
        //
    }
}
