<?php

namespace Costa\Core\Modules\Video\UseCases\DTO\Created;

use Costa\Core\Modules\Video\Enums\Rating;

class Output
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public int $yearLaunched,
        public int $duration,
        public bool $opened,
        public Rating $rating,
    ) {
        //
    }
}
