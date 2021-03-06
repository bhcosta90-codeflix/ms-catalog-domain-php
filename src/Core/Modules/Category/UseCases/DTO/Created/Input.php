<?php

namespace Costa\Core\Modules\Category\UseCases\DTO\Created;

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
