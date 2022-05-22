<?php

namespace Costa\Core\Utils\Contracts;

interface EventManagerInterface
{
    public function dispatch(object $data): void;
}
