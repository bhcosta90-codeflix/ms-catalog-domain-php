<?php

namespace Costa\Core\Utils\Exceptions;

use Costa\Core\Utils\Notifications\DomainNotification;
use Exception;

class DomainNotificationException extends Exception
{
    protected array $errors;

    public function __construct(DomainNotification $notification, int $status = 422)
    {
        $this->errors = $notification->toArray();
        parent::__construct((string) $notification, $status);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
