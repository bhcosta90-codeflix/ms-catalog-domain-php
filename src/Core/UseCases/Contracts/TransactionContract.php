<?php

namespace Costa\Core\UseCases\Contracts;

interface TransactionContract
{
    public function commit(): void;

    public function rollback(): void;
}
