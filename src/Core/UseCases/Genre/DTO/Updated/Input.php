<?php

namespace Costa\Core\UseCases\Genre\DTO\Updated;

class Input
{
    public function __construct(
        public string $id,
        public string $name,
        public bool|null $isActive = null,
        public array $categories = [],
    ) {
        //
    }
}
