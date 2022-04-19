<?php

namespace Costa\Core\UseCases\Genre\DTO\UpdatedGenre;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description = '',
        public bool $isActive = true,
        public string $createdAt = '',
        public string $updatedAt = '',
    ) {
        //
    }
}
