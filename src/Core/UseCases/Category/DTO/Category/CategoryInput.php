<?php

namespace Costa\Core\UseCases\Category\DTO\Category;

final class CategoryInput
{
    public function __construct(
        public string $name,
        public string $description = '',
        public bool $isActive = true,
    ) {
        //
    }
}
