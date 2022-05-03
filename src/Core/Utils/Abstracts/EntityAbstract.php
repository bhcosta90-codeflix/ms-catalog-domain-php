<?php

namespace Costa\Core\Utils\Abstracts;

use Costa\Core\Utils\Notifications\DomainNotification;
use Costa\Core\Utils\Traits\MagicMethodsTrait;

abstract class EntityAbstract
{
    use MagicMethodsTrait;

    protected DomainNotification $domainNotification;

    public function __construct()
    {
        $this->domainNotification = new DomainNotification;
    }
}
