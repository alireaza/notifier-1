<?php

namespace AsanBar\Notifier\Traits;

use Asanbar\Notifier\Models\Message;
use Asanbar\Notifier\NotificationProviders\MessageProviders\MessageAbstract;
use Illuminate\Support\Facades\Log;

trait MessageTrait
{
    private $current_provider = NULL;
    private $title;
    private $body;
    private $user_ids;
    private $expire_at;
    private $options;

    public function sendMessage()
    {
        if (empty(env("MESSAGE_PROVIDERS_PRIORITY")) || !env("MESSAGE_PROVIDERS_PRIORITY")) {
            return FALSE;
        }

        $message_providers_priority = explode(",", env("MESSAGE_PROVIDERS_PRIORITY"));

        if (!$message_providers_priority) {
            $this->logNoProvidersAvailable();

            return FALSE;
        }

        foreach ($message_providers_priority as $message_provider) {
            $current_provider = MessageAbstract::resolve($message_provider);

            if (!$current_provider) {
                continue;
            }

            $this->current_provider = $message_provider;

            $response = $current_provider->options($this->options)
                                         ->send(
                                             $this->title,
                                             $this->body,
                                             $this->user_ids,
                                             $this->expire_at
                                         );

            if (isset($response["result_id"]) && $response["result_id"] != NULL) {
                $this->logMessageSent();

                Message::createSentMessages(
                    $this->current_provider,
                    $this->user_ids,
                    $this->title,
                    $this->body,
                    $response["result_id"]
                );

                continue;
            }

            Message::createSendFailedMessages(
                $this->current_provider,
                $this->user_ids,
                $this->title,
                $this->body,
                $response
            );

            $this->logMessageSendFailed();
        }

        return FALSE;
    }

    public function logNoProvidersAvailable()
    {
        Log::error("Notifier: No MESSAGE_PROVIDERS_PRIORITY env available");
    }

    public function logMessageSent()
    {
        Log::info(
            "Notifier: Message sent via " .
            strtoupper($this->current_provider) .
            ", Title: " . $this->title .
            ", Body: " . $this->body .
            ", User Ids: " . implode(",", $this->user_ids)
        );
    }

    public function logMessageSendFailed()
    {
        Log::warning("Notifier: Sending message failed via " .
            strtoupper($this->current_provider) .
            ", Title: " . $this->title .
            ", Body: " . $this->body .
            ", User Ids: " . implode(",", $this->user_ids)
        );
    }
}