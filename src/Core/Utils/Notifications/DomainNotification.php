<?php

namespace Costa\Core\Utils\Notifications;

class DomainNotification
{
    public function __construct(private array $errors = [])
    {
    }

    public function getErros(): array
    {
        return $this->errors;
    }

    public function addError($error): self
    {
        array_push($this->errors, $error);
        return $this;
    }

    public function hasError(): bool
    {
        return (bool) count($this->errors);
    }

    public function message(?string $context = null): string
    {
        $result = [];

        foreach ($this->errors as $error) {
            if ($context === null || $error['context'] == $context) {
                $result[] = "{$error['context']}: {$error['message']}";
            }
        }

        return implode(', ', $result);
    }

    public function toArray(?string $context = null): array
    {
        $result = [];
        foreach ($this->errors as $error) {
            if ($context === null || $error['context'] == $context) {
                if (!array_key_exists($error['context'], $result)) {
                    $result[$error['context']] = [];
                }
                array_push($result[$error['context']], $error['message']);
            }
        }
        return $result;
    }

    public function __toString()
    {
        return $this->message();
    }
}
