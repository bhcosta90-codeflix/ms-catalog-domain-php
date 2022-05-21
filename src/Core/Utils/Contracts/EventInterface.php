<?php

namespace Costa\Core\Utils\Contracts;

interface EventInterface
{
    public function getEventName(): string;

    public function getPayload(): array;
}
