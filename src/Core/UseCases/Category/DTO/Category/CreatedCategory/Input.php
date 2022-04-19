<?php

namespace Costa\Core\UseCases\Category\DTO\Category\CreatedCategory;

class Input
{
    public function __construct(
        public string $name,
        public string|null $description = null,
        public bool $isActive = true,
        public string $createdAt = ''
    ) {
        //
    }
}
