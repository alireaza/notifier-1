<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders;

interface PushInterface
{
    /**
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param array|NULL $extra
     * @return mixed
     */
    public function send(string $heading, string $content, array $player_ids, array $extra = NULL);

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options);
}