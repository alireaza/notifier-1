<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders;

use Exception;
use Illuminate\Support\Facades\Log;

abstract class PushAbstract implements PushInterface
{
    /**
     * @param string $provider
     * @return bool|PushInterface
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
     * @return mixed
     */
    abstract function send(string $heading, string $content, array $player_ids, array $extra = NULL);

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {
        return $this;
    }
}