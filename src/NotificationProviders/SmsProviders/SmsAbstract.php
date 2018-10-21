<?php

namespace Asanbar\Notifier\NotificationProviders\SmsProviders;

use Exception;

abstract class SmsAbstract implements SmsInterface
{
    public $from;

    /**
     * @param string $provider
     * @return bool|self
     */
    public static final function resolve(string $provider)
    {
        try {
            $provider_class = sprintf("%s%s%s%s%s",
                "Asanbar\\Notifier\\NotificationProviders\\SmsProviders\\",
                ucwords($provider),
                "\\",
                ucwords($provider),
                "Provider"
            );

            return new $provider_class;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    /**
     * @param string $message
     * @param array $numbers
     * @param string|NULL $datetime
     * @param int $expire_at
     * @return array
     */
    abstract function send(string $message, array $numbers, string $datetime = NULL, int $expire_at = 0): array;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options): self
    {
        return $this;
    }
}