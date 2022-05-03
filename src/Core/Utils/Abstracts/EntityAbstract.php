<?php

namespace Costa\Core\Utils\Abstracts;

use Costa\Core\Utils\Notifications\DomainNotification;
use Costa\Core\Utils\Traits\MagicMethodsTrait;

abstract class EntityAbstract
{
    use MagicMethodsTrait;

    protected DomainNotification $notifications;

    public function __construct()
    {
        $this->notifications = new DomainNotification;
    }
}
