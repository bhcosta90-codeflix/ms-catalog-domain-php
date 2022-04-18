<?php

namespace Costa\Core\UseCases\Category\DTO\Category\CategoryCreated;

class Input
{
    public function __construct(
        public string $name,
        public string $description = '',
        public bool $isActive = true,
    ) {
        //
    }
}
