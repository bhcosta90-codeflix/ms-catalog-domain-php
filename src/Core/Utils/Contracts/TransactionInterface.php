<?php

namespace Costa\Core\Utils\Contracts;

interface TransactionInterface
{
    public function commit(): void;

    public function rollback(): void;
}
