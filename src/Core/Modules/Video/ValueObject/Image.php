<?php

namespace Costa\Core\Modules\Video\ValueObject;

use Costa\Core\Utils\Traits\MagicMethodsTrait;

class Image
{
    use MagicMethodsTrait;
    
    public function __construct(
        private string $path,
    )
    {
        //
    }
}
