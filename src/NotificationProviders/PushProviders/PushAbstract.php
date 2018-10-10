<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders;

use Asanbar\Notifier\NotificationProviders\PushProviders\OneSignal\OneSignalProvider;
use Illuminate\Support\Facades\Log;

abstract class PushAbstract implements PushInterface
{
    abstract function send(string $heading, string $content, array $player_ids, $extra = null, int $expire_at = 0);

    public static final function resolve($provider)
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
        } catch (\Exception $e) {
            return false;
        }
    }
}