<?php

namespace Costa\Core\CastMember\Entities;

use Costa\Core\CastMember\Enums\CastMemberType;
use Costa\Core\Domains\Traits\MagicMethodsTrait;
use Costa\Core\Domains\Validations\DomainValidation;
use Costa\Core\Domains\ValueObject\Uuid;
use DateTime;

class CastMember
{
    use MagicMethodsTrait;

    public function __construct(
        protected string $name,
        protected CastMemberType $type,
        protected ?Uuid $id = null,
        protected bool $isActive = true,
        protected DateTime|string $createdAt = '',
        protected DateTime|string $updatedAt = '',
    ) {
        $this->id = $this->id ?? Uuid::random();
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

    public function changeType(CastMemberType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function update(
        string $name,
    ) {
        $this->name = $name;
        $this->validated();
    }

    protected function validated()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
    }
}
