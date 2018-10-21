<?php

namespace Asanbar\Notifier\NotificationProviders\MessageProviders\Database;

use Asanbar\Notifier\NotificationProviders\MessageProviders\MessageAbstract;

class DatabaseProvider extends MessageAbstract
{
    /**
     * @param string $title
     * @param string $body
     * @param array $user_ids
     * @param int $expire_at
     * @return array
     */
    public function send(string $title, string $body, array $user_ids, int $expire_at = 0): array
    {
        return [
            "result_id" => "success",
            "errors" => [],
        ];
    }
}