<?php

namespace Costa\Core\Domains\Entities;

use Costa\Core\Domains\Traits\MagicMethodsTrait;
use Costa\Core\Domains\Validations\DomainValidation;
use Costa\Core\Domains\ValueObject\Uuid;

final class CategoryDomain
{
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $id = "",
        protected string $name = "",
        protected string|null $description = "",
        protected bool $isActive = true
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->validated();
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function enable(): void
    {
        $this->isActive = true;
    }

    public function update(
        string $name,
        string|null $description
    ) {
        $this->name = $name;
        $this->description = $description;
    }

    public function validated()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name, 2);
        DomainValidation::strCanNullAndMinLength($this->description);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}
