<?php

namespace Asanbar\Notifier\NotificationProviders\SmsProviders\SmsIr;

use Asanbar\Notifier\Constants\SmsConfigs;
use Asanbar\Notifier\NotificationProviders\SmsProviders\SmsAbstract;
use Asanbar\Notifier\Traits\RestConnector;

class SmsIrProvider extends SmsAbstract
{
    use RestConnector;

    public function getToken()
    {
        $request = [
            "UserApiKey" => config('notifier.sms.smsir.api_key'),
            "SecretKey" => config('notifier.sms.smsir.secret_key'),
            "System" => "laravel_v_1_4",
        ];

        $response = $this->post(
            config('notifier.sms.smsir.token'),
            ["json" => $request]
        );

        if(array_key_exists("TokenKey", $response)) {
            return $response["TokenKey"];
        } else {
            return false;
        }
    }

    public function send(array $messages, array $numbers, string $datetime = null)
    {
        $body = [
            "Messages" => $messages,
            "MobileNumbers" => $numbers,
            "LineNumber" => config('notifier.sms.smsir.line_number'),
        ];

        if($datetime) {
            $body["SendDateTime"] = $datetime;
        }

        $headers = [
            "x-sms-ir-secure-token" => $this->getToken()
        ];

        $this->post(
            config('notifier.sms.smsir.uri'),
            [
                "json" => $body,
                "headers" => $headers
            ]
        );

        return true;
    }
}