<?php

namespace Costa\Core\Domains\Entities;

use Costa\Core\Domains\Traits\MagicMethodsTrait;
use Costa\Core\Domains\Validations\DomainValidation;
use Costa\Core\Domains\ValueObject\Uuid;
use DateTime;

class Genre
{
    use MagicMethodsTrait;

    public function __construct(
        protected string $name,
        protected ?Uuid $id = null,
        protected bool $isActive = true,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
        protected array $categories = [],
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?? new DateTime();
        $this->updatedAt = $this->updatedAt ?? new DateTime();
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
        string $name
    ) {
        $this->name = $name;
        $this->validated();
    }

    public function addCategory(string $category)
    {
        array_push($this->categories, $category);
    }

    public function removeCategory(string $category)
    {
        unset($this->categories[array_search($category, $this->categories)]);
    }

    protected function validated()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name, 2);
    }
}
