<?php

namespace Asanbar\Notifier\NotificationProviders\SmsProviders;

interface SmsInterface
{
    /**
     * @param string $message
     * @param array $numbers
     * @param string|NULL $datetime
     * @param int $expire_at
     * @return array
     */
    public function send(string $message, array $numbers, string $datetime = NULL, int $expire_at = 0): array;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options);
}