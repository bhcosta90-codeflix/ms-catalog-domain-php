<?php

namespace Costa\Core\Modules\Genre\UseCases\DTO\Created;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $is_active = true,
        public string $created_at = '',
        public string $updated_at = '',
    ) {
        //
    }
}
