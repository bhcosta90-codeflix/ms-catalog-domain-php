<?php

namespace Costa\Core\CastMember\UseCases\DTO\Created;

use Costa\Core\CastMember\Enums\CastMemberType;

class Output
{
    public function __construct(
        public string $id,
        public string $name,
        public CastMemberType $type,
        public bool $is_active = true,
        public string $created_at = '',
        public string $updated_at = '',
    ) {
        //
    }
}
