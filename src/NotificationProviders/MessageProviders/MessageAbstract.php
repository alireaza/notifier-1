<?php

namespace Asanbar\Notifier\NotificationProviders\MessageProviders;

use Exception;

abstract class MessageAbstract implements MessageInterface
{
    /**
     * @param string $title
     * @param string $body
     * @return mixed
     */
    abstract function send(string $title, string $body);

    /**
     * @param string $provider
     * @return bool|MessageInterface
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
            return false;
        }
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {
        return $this;
    }
}