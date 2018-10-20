<?php

namespace AsanBar\Notifier\Traits;

use Asanbar\Notifier\Models\Push;
use Asanbar\Notifier\NotificationProviders\PushProviders\PushAbstract;
use Illuminate\Support\Facades\Log;

trait PushTrait
{
    private $current_provider = NULL;
    private $heading;
    private $content;
    private $player_ids;
    private $data;
    private $options;

    public function sendPush()
    {
        if (empty(env("PUSH_PROVIDERS_PRIORITY")) || !env("PUSH_PROVIDERS_PRIORITY")) {
            return FALSE;
        }

        $push_providers_priority = explode(",", env("PUSH_PROVIDERS_PRIORITY"));

        if (!$push_providers_priority) {
            $this->logNoProvidersAvailable();

            return FALSE;
        }

        foreach ($push_providers_priority as $push_provider) {
            $current_provider = PushAbstract::resolve($push_provider);

            if (!$current_provider) {
                continue;
            }

            $this->current_provider = $push_provider;

            $player_ids_chunks = array_chunk($this->player_ids, 2000);

            foreach ($player_ids_chunks as $player_ids) {
                $response = $current_provider->options($this->options)
                                             ->send(
                                                 $this->heading,
                                                 $this->content,
                                                 $player_ids,
                                                 $this->data
                                             );

                if (isset($response["result_id"]) && $response["result_id"] != NULL) {
                    $this->logPushSent();

                    Push::createSentPushes(
                        $this->current_provider,
                        $player_ids,
                        $this->heading,
                        $this->content,
                        $this->data,
                        $response["result_id"]
                    );

                    continue;
                }

                Push::createSendFailedPushes(
                    $this->current_provider,
                    $player_ids,
                    $this->heading,
                    $this->content,
                    $this->data,
                    $response
                );

                $this->logPushSendFailed();
            }
        }

        return FALSE;
    }

    public function logNoProvidersAvailable()
    {
        Log::error("Notifier: No PUSH_PROVIDERS_PRIORITY env available");
    }

    public function logPushSent()
    {
        Log::info(
            "Notifier: Push sent via " .
            strtoupper($this->current_provider) .
            ", Heading: " . $this->heading .
            ", Content: " . $this->content .
            ", Player Ids: " . implode(",", $this->player_ids)
        );
    }

    public function logPushSendFailed()
    {
        Log::warning("Notifier: Sending push failed via " .
            strtoupper($this->current_provider) .
            ", Heading: " . $this->heading .
            ", Content: " . $this->content .
            ", Player Ids: " . implode(",", $this->player_ids)
        );
    }
}
