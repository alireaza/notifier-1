<?php

namespace Asanbar\Notifier\NotificationProviders\PushProviders\Onesignal;

use Asanbar\Notifier\Constants\PushConfigs;
use Asanbar\Notifier\NotificationProviders\PushProviders\PushAbstract;
use Asanbar\Notifier\Traits\RestConnector;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OnesignalProvider extends PushAbstract
{
    use RestConnector;

    public $send_uri = "https://onesignal.com/api/v1/notifications";

    /**
     * Implementing send push notification
     *
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param null $extra
     * @param int $expire_at
     * @return bool
     */
    public function send(string $heading, string $content, array $player_ids, $extra = null, int $expire_at = 0)
    {
        $request = [
            "app_id" => config("notifier.push.onesignal.app_id"),
            "data" => $extra,
            "headings" => ["en" => $heading],
            "contents" => ["en" => $content]
        ];

        $headers = [
            "Content-Type" => "application/json; charset=utf-8",
            "Authorization" => "Basic " . config("notifier.push.onesignal.authorization")
        ];

        $request["include_player_ids"] = $player_ids;

        try {
            $response = $this->post(
                $this->send_uri,
                [
                    "headers" => $headers,
                    "body" => json_encode($request)
                ]
            );

            $response = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $exception) {
            Log::debug('onesignal.error', $exception->getTrace());
        }

        // This code should be omitted & not handled inside the package!
        $this->updateUserDevicesIfTokensExpired($response);

        $result["result_id"] = $response["id"] ?? null;
        $result["errors"] = $response["errors"] ?? null;

        return $result;
    }

    /**
     * In send push response, if some tokens have been expired, then they should be updated as logout in database
     *
     * @param array $response
     */
    protected function updateUserDevicesIfTokensExpired(array $response)
    {
        if(array_key_exists("errors", $response)) {
            $errors = $response["errors"];

            if(array_key_exists("invalid_player_ids", $errors)) {
                $invalid_player_ids = $errors["invalid_player_ids"];

                try {
                    DB::table("users_devices")
                      ->whereIn("one_signal_token", $invalid_player_ids)
                      ->update(["logout" => 1]);
                } catch(Exception $e) {
                    //
                }
            }
        }
    }
}
