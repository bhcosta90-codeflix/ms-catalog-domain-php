<?php

namespace Costa\Core\Modules\Video\UseCases\DTO\Created;

use Costa\Core\Modules\Video\Enums\Rating;

class Input
{
    public function __construct(
        public string $title,
        public string $description,
        public int $yearLaunched,
        public int $duration,
        public Rating $rating,
        public array $categories = [],
        public array $genres = [],
        public array $castMembers = [],
        public array $files = [],
    ) {
        //
    }
}
