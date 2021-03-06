<?php

namespace Costa\Core\Modules\Genre\UseCases\DTO\Updated;

class Input
{
    public function __construct(
        public string $id,
        public string $name,
        public ?bool $isActive = null,
        public ?array $categories = null,
    ) {
        //
    }
}
