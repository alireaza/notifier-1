<?php

namespace Asanbar\Notifier\NotificationProviders\MessageProviders;

use Exception;

abstract class MessageAbstract implements MessageInterface
{
    /**
     * @param string $provider
     * @return bool|self
     */
    public static final function resolve(string $provider)
    {
        try {
            $provider_class = sprintf("%s%s%s%s%s",
                "Asanbar\\Notifier\\NotificationProviders\\MessageProviders\\",
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
     * @param string $title
     * @param string $body
     * @param array $user_ids
     * @param int $expire_at
     * @return array
     */
    abstract function send(string $title, string $body, array $user_ids, int $expire_at = 0): array;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options)
    {
        return $this;
    }
}