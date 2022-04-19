<?php

namespace Costa\Core\UseCases\Category\DTO\Category\UpdatedCategory;

class Input
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $description = null,
        public bool|null $isActive = null,
        public string $createdAt = ''
    ) {
        //
    }
}
