<?php

namespace Costa\Core\UseCases\Genre\DTO\Find;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $isActive = true,
        public string $created_at = '',
        public string $updated_at = '',
    ) {
        //
    }
}
