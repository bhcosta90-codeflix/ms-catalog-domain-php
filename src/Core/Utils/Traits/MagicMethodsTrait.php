<?php

namespace Costa\Core\Utils\Traits;

use Costa\Core\Utils\Exceptions\PropertyException;

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

    public function createdAt($format = 'Y-m-d H:i:s'): string
    {
        return $this->createdAt->format($format);
    }
    
    public function updatedAt($format = 'Y-m-d H:i:s'): string
    {
        return $this->updatedAt->format($format);
    }
}
