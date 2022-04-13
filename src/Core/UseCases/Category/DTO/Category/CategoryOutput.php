<?php

namespace Costa\Core\UseCases\Category\DTO\Category;

final class CategoryOutput extends CategoryInput
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
