<?php

namespace Asanbar\Notifier\NotificationProviders\SmsProviders;

use Exception;

abstract class SmsAbstract implements SmsInterface
{
    public $from;

    /**
     * @param string $provider
     * @return bool|SmsInterface
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
     * @return mixed
     */
    abstract function send(string $message, array $numbers, string $datetime = NULL);

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {
        return $this;
    }
}