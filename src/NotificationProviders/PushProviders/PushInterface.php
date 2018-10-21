<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders;

interface PushInterface
{
    /**
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param array|NULL $extra
     * @param int $expire_at
     * @return array
     */
    public function send(string $heading, string $content, array $player_ids, array $extra = NULL, int $expire_at = 0): array;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options): self;
}