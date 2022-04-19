<?php

namespace Costa\Core\UseCases\Category\DTO\Created;

class Input
{
    public function __construct(
        public string $name,
        public string|null $description = null,
        public bool $isActive = true,
        public string $createdAt = '',
    ) {
        //
    }
}