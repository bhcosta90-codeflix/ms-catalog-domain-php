<?php

namespace Costa\Core\Modules\CastMember\UseCases\DTO\Created;

use Costa\Core\Modules\CastMember\Enums\CastMemberType;

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
