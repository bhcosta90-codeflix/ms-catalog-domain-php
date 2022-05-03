<?php

namespace Costa\Core\Utils\Factories;

use Costa\Core\Utils\Contracts\ValidatorInterface;
use Costa\Core\Utils\Validations\VideoRakitValidation;

class VideoValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new VideoRakitValidation;
    }
}