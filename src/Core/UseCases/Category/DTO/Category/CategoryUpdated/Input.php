<?php

namespace Costa\Core\UseCases\Category\DTO\Category\CategoryUpdated;

class Input
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description = '',
        public bool $isActive = true,
    ) {
        //
    }
}
