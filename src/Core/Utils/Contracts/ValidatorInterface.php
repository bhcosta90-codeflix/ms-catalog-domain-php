<?php

namespace Costa\Core\Utils\Contracts;

use Costa\Core\Utils\Abstracts\EntityAbstract;

interface ValidatorInterface
{
    public function validate(EntityAbstract $entity): void;
}
