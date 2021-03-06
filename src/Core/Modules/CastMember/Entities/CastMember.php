<?php

namespace Costa\Core\Modules\CastMember\Entities;

use Costa\Core\Modules\CastMember\Enums\CastMemberType;
use Costa\Core\Utils\Contracts\EntityInterface;
use Costa\Core\Utils\Traits\MagicMethodsTrait;
use Costa\Core\Utils\Validations\DomainValidation;
use Costa\Core\Utils\ValueObject\Uuid;
use DateTime;

class CastMember implements EntityInterface
{
    use MagicMethodsTrait;

    public function __construct(
        protected string $name,
        protected CastMemberType $type,
        protected ?Uuid $id = null,
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
