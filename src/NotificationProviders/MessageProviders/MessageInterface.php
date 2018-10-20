<?php

namespace Asanbar\Notifier\NotificationProviders\MessageProviders;


interface MessageInterface
{
    /**
     * @param string $title
     * @param string $body
     * @return mixed
     */
    public function send(string $title, string $body);

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options);
}