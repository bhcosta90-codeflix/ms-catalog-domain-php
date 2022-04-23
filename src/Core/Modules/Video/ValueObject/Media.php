<?php

namespace Costa\Core\Modules\Video\ValueObject;

use Costa\Core\Modules\Video\Enums\Status;
use Costa\Core\Utils\Traits\MagicMethodsTrait;

class Media
{
    use MagicMethodsTrait;
    
    public function __construct(
        private string $path,
        private ?Status $status = Status::PENDING,
        private ?string $encode = null,
    )
    {
        //
    }
}
