<?php

namespace Costa\Core\Utils\UseCases\Contracts;

interface TransactionContract
{
    public function commit(): void;

    public function rollback(): void;
}
