<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders\Chabok;

use Asanbar\Notifier\Constants\PushConfigs;
use Asanbar\Notifier\NotificationProviders\PushProviders\PushAbstract;
use Asanbar\Notifier\Traits\RestConnector;

class ChabokProvider extends PushAbstract
{
    use RestConnector;

    /**
     * Implementing send push notification
     *
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param null $extra
     * @return array
     */
    public function send(string $content, string $heading, array $player_ids, $extra = null): array
    {

        $message = $this->getMessage($content, $heading, $extra);
        $headers = $this->getHeaders();

        $player_ids_chunks = array_chunk($player_ids, 2000);

        foreach ($player_ids_chunks as $player_ids) {
            $message["user"] = $player_ids;
            $uri = $this->getUri();

            return $this->post(
                $uri,
                [
                    'headers' => $headers,
                    'body' => json_encode($message)
                ]
            );

        }

    }

    private function getMessage(string $content, string $heading, $extra = null) : array
    {
        return [
            "channel" => "",
            "content" => $content,
            "data" => $extra,
            "notification" => [
                "title" => $heading,
                "body" => $content
            ]
        ];
    }

    private function getHeaders() : array
    {
        return [
            "Content-Type" => "application/json; charset=utf-8",
            "accept" => "application/json",
            // "Authorization" => "Basic " . PushConfigs::CHABOK_AUTHORIZATION
        ];
    }

    private function getUri(): string
    {
        $baseUri = PushConfigs::CHABOK_URL;
        if (config('app.env') !== "production") {
            $baseUri = PushConfigs::CHABOK_URL_DEV;
        }
        return $baseUri . "push/toUsers?access_token=" . PushConfigs::CHABOK_ACCESS_TOKEN;
    }

}