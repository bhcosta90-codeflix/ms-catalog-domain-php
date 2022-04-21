<?php

namespace Costa\Core\Modules\Category\Entities;

use Costa\Core\Utils\Traits\MagicMethodsTrait;
use Costa\Core\Utils\Validations\DomainValidation;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;

class Category
{
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $id = "",
        protected string $name = "",
        protected string|null $description = "",
        protected bool $isActive = true,
        protected DateTime|string $createdAt = '',
        protected DateTime|string $updatedAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
        $this->updatedAt = $this->updatedAt ? new DateTime($this->updatedAt) : new DateTime();
        $this->validated();
    }

    public function disable(): self
    {
        $this->isActive = false;
        return $this;
    }

    public function enable(): self
    {
        $this->isActive = true;
        return $this;
    }

    public function update(
        string $name,
        string|null $description
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->validated();
    }

    protected function validated()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strCanNullAndMinLength($this->description);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}
