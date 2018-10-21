<?php

namespace Asanbar\Notifier\NotificationProviders\SmsProviders\Sms0098;

use Asanbar\Notifier\NotificationProviders\SmsProviders\SmsAbstract;
use Asanbar\Notifier\Traits\RestConnector;

class Sms0098Provider extends SmsAbstract
{
    use RestConnector;

    private $send_uri = "http://www.0098sms.com/sendsmslink.aspx";
    private $domain   = "0098";
    private $from;
    private $username;
    private $password;

    public function __construct()
    {
        $this->from     = config("notifier.sms.sms0098.from");
        $this->username = config("notifier.sms.sms0098.username");
        $this->password = config("notifier.sms.sms0098.password");
    }

    /**
     * @param string $message
     * @param array $numbers
     * @param string|NULL $datetime
     * @param int $expire_at
     * @return array
     */
    public function send(string $message, array $numbers, string $datetime = NULL, int $expire_at = 0): array
    {
        $query = [
            "FROM"     => $this->from,
            "TO"       => reset($numbers),
            "TEXT"     => $message,
            "USERNAME" => $this->username,
            "PASSWORD" => $this->password,
            "DOMAIN"   => $this->domain,
        ];

        $response = $this->get(
            $this->send_uri,
            $query
        );

        if (substr(trim($response->getBody()
                                 ->getContents()), 0, 1) == 0) {
            $result["result_id"] = 0;
            $result["errors"]    = NULL;
        } else {
            $result["result_id"] = NULL;
            $result["errors"]    = [
                substr(trim($response->getBody()
                                     ->getContents()), 0, 2),
            ];
        }

        return $result;
    }
}