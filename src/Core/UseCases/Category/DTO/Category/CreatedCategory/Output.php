<?php

namespace Costa\Core\UseCases\Category\DTO\Category\CreatedCategory;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description = '',
        public bool $isActive = true,
        public string $createdAt = ''
    ) {
        //
    }
}
