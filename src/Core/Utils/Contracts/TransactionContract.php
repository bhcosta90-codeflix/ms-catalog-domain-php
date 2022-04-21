<?php

namespace Costa\Core\Utils\Contracts;

interface TransactionContract
{
    public function commit(): void;

    public function rollback(): void;
}
