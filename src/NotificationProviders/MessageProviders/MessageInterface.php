<?php

namespace Asanbar\Notifier\NotificationProviders\MessageProviders;


interface MessageInterface
{
    /**
     * @param string $title
     * @param string $body
     * @param array $user_ids
     * @param int $expire_at
     * @return array
     */
    public function send(string $title, string $body, array $user_ids, int $expire_at = 0): array;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options);
}