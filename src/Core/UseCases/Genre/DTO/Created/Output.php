<?php

namespace Costa\Core\UseCases\Genre\DTO\Created;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $isActive = true,
        public string $createdAt = '',
        public string $updatedAt = '',
    ) {
        //
    }
}
