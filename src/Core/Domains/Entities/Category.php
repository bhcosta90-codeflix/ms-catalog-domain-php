<?php

namespace Costa\Core\Domains\Entities;

use Costa\Core\Domains\Traits\MagicMethodsTrait;
use Costa\Core\Domains\Validations\DomainValidation;
use Costa\Core\Domains\ValueObject\Uuid;
use DateTime;

final class Category
{
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $id = "",
        protected string $name = "",
        protected string|null $description = "",
        protected bool $isActive = true,
        protected DateTime|string $createdAt = ''
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
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
