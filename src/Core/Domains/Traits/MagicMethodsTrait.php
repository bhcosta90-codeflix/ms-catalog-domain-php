<?php

namespace Costa\Core\Domains\Traits;

use Costa\Core\Domains\Exceptions\PropertyException;

trait MagicMethodsTrait
{
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        $nameClass = get_class($this);
        throw new PropertyException("Property {$name} not found in class {$nameClass}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }
}
