<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders;

use Exception;

abstract class PushAbstract implements PushInterface
{
    /**
     * @param string $provider
     * @return bool|self
     */
    public static final function resolve(string $provider)
    {
        try {
            $provider_class = sprintf("%s%s%s%s%s",
                "Asanbar\\Notifier\\NotificationProviders\\PushProviders\\",
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
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param array|NULL $extra
     * @param int $expire_at
     * @return array
     */
    abstract function send(string $heading, string $content, array $player_ids, array $extra = NULL, int $expire_at = 0): array;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options)
    {
        return $this;
    }
}