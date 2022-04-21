<?php

namespace Costa\Core\Modules\CastMember\UseCases\DTO\Created;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public int $type,
        public bool $is_active = true,
        public string $created_at = '',
        public string $updated_at = '',
    ) {
        //
    }
}
