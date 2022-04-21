<?php

namespace Costa\Core\Genre\UseCases\DTO\Created;

class Input
{
    public function __construct(
        public string $name,
        public bool $isActive = true,
        public string $createdAt = '',
        public ?array $categories = null,
    ) {
        //
    }
}
