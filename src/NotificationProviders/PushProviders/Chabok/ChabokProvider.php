<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders\Chabok;

use Asanbar\Notifier\NotificationProviders\PushProviders\PushAbstract;
use Asanbar\Notifier\Traits\RestConnector;
use Illuminate\Support\Facades\Log;

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
     * @param int $expire_at
     * @return array
     */
    public function send(string $heading, string $content, array $player_ids, $extra = null, int $expire_at = 0) : array
    {
        $messages = [];
        $headers = $this->getHeaders();

        foreach ($player_ids as $key => $player_id) {
            $messages[$key] = $this->getMessage($content, $heading, $extra, $expire_at);
            $messages[$key]["user"] = $player_id;
        }

        $response = $this->post(
            $this->getUri(),
            [
                'headers' => $headers,
                'body' => json_encode($messages)
            ]
        );

        $response = json_decode($response->getBody()->getContents(), true);
        
        $result = $response[0];
        $result['result_id'] = time();
        $result['error'] = [];

        return $result;

    }


    private function getMessage(string $heading, string $content, $extra = null, int $expire_at = 0) : array
    {
        return [
            "channel" => "",
            "content" => $content,
            "data" => $extra,
            "notification" => [
                "title" => $heading,
                "body" => $content
            ],
            "ttl" => $expire_at,
        ];
    }

    private function getHeaders() : array
    {
        return [
            "Content-Type" => "application/json; charset=utf-8",
            "accept" => "application/json",
            // "Authorization" => "Basic " . config('notifier.push.chabok.access_token')
        ];
    }

    private function getUri() : string
    {
        $baseUri = config('notifier.push.chabok.uri');
        if (config('app.env') !== "production") {
            $baseUri = config('notifier.push.chabok.uri_dev');
        }
        return $baseUri . "push/toUsers?access_token=" . config('notifier.push.chabok.access_token');
    }

}