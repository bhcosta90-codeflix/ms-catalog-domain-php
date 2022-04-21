<?php

namespace Costa\Core\Utils\Domains\Validations;

use Costa\Core\Utils\Domains\Exceptions\EntityValidationException;

final class DomainValidation
{
    public static function notNull(string $value, string $exceptionMessage = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptionMessage ?? "Should not be empty value");
        }
    }

    public static function strCanNullAndMaxLength(string|null $value, int $length = 255)
    {
        !is_null($value) && !empty($value) && self::strMaxLength($value, $length);
    }

    public static function strCanNullAndMinLength(string|null $value, int $length = 2)
    {
        !is_null($value) && !empty($value) && self::strMinLength($value, $length);
    }

    public static function strMaxLength(string $value, int $length = 255, string $exceptionMessage = null)
    {
        if (strlen($value) > $length) {
            throw new EntityValidationException($exceptionMessage ?? "The value must not be greater than {$length} characters");
        }
    }

    public static function strMinLength(string $value, int $length = 2, string $exceptionMessage = null)
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($exceptionMessage ?? "The value must at least {$length} characters");
        }
    }

}
