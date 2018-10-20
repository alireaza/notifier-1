<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders\Chabok;

use Asanbar\Notifier\NotificationProviders\PushProviders\PushAbstract;
use Asanbar\Notifier\Traits\RestConnector;
use Illuminate\Support\Facades\Log;

class ChabokProvider extends PushAbstract
{
    use RestConnector;

    private $fallback = FALSE;

    /**
     * Implementing send push notification
     *
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param array|NULL $extra
     * @return mixed
     */
    public function send(string $heading, string $content, array $player_ids, array $extra = NULL): array
    {
        $messages = [];
        $headers  = $this->getHeaders();

        foreach ($player_ids as $key => $player_id) {
            $messages[$key]         = $this->getMessage($content, $heading, $extra);
            $messages[$key]["user"] = $player_id;
        }

        $response = $this->post(
            $this->getUri(),
            [
                'headers' => $headers,
                'body'    => json_encode($messages),
            ]
        );

        $response = json_decode($response->getBody()
                                         ->getContents(), TRUE);

        $result              = $response[0];
        $result['result_id'] = time();
        $result['error']     = [];

        return $result;

    }

    private function getHeaders(): array
    {
        return [
            "Content-Type" => "application/json; charset=utf-8",
            "accept"       => "application/json",
            // "Authorization" => "Basic " . config('notifier.push.chabok.access_token')
        ];
    }

    private function getMessage(string $heading, string $content, $extra = NULL): array
    {
        $message = [
            "channel"      => "",
            "content"      => $content,
            "data"         => $extra,
            "notification" => [
                "title" => $heading,
                "body"  => $content,
            ],
        ];

        if ($this->fallback) {
            array_push($message, [
                'fallback' => [
                    'content' => $content,
                    'delay'   => 0,
                    'media'   => $this->fallback,
                ],
            ]);
        }

        return $message;
    }

    private function getUri(): string
    {
        $baseUri = config('notifier.push.chabok.uri');
        if (config('app.env') !== "production") {
            $baseUri = config('notifier.push.chabok.uri_dev');
        }
        return $baseUri . "push/toUsers?access_token=" . config('notifier.push.chabok.access_token');
    }

    /**
     * @param array $options
     * @return $this
     */
    function options(array $options)
    {
        if (array_key_exists('fallback', $options)) {
            $this->fallback = $options['fallback'];
        }

        return $this;
    }
}