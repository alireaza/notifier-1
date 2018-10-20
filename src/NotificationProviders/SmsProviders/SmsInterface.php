<?php

namespace Asanbar\Notifier\NotificationProviders\SmsProviders;

interface SmsInterface
{
    /**
     * @param string $message
     * @param array $numbers
     * @param string|NULL $datetime
     * @return mixed
     */
    public function send(string $message, array $numbers, string $datetime = NULL);

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options);
}