<?php

namespace Asanbar\Notifier;

use Asanbar\Notifier\Jobs\SendMessageJob;
use Asanbar\Notifier\Jobs\SendPushJob;
use Asanbar\Notifier\Jobs\SendSmsJob;
use Asanbar\Notifier\Models\Message;
use Asanbar\Notifier\Models\Push;
use Asanbar\Notifier\Models\Sms;

class Notifier
{
    private static $expire_at = 0;

    private static $options = [];

    public static function sendPush(string $heading, string $content, array $player_ids, array $extra = NULL)
    {
        dispatch(new SendPushJob($heading, $content, $player_ids, $extra, self::$expire_at, self::$options));

        return TRUE;
    }

    public static function sendSms(string $message, array $numbers)
    {
        dispatch(new SendSmsJob($message, $numbers, self::$expire_at, self::$options));

        return TRUE;
    }

    public static function sendMessage(string $title, string $body, array $user_ids)
    {
        dispatch(new SendMessageJob($title, $body, $user_ids, self::$expire_at, self::$options));

        return TRUE;
    }

    public static function setExpireAt($expire_at)
    {
        self::$expire_at = $expire_at;
    }

    public static function options(array $options = [])
    {
        self::$options = $options;
    }

    public static function getPushes($player_ids, string $from_datetime = NULL, string $to_datetime = NULL,
                                     $extra_field = NULL, array $extra_values = NULL)
    {
        return Push::getPushes(
            $player_ids,
            $from_datetime,
            $to_datetime,
            $extra_field,
            $extra_values
        );
    }

    public static function getSmses(array $numbers)
    {
        return Sms::getSmses($numbers);
    }

    public static function getMessages(array $user_ids, string $status = NULL)
    {
        return Message::getMessages($user_ids, $status);
    }

    public static function getSeenMessages(array $user_ids)
    {
        return Message::getSeenMessages($user_ids);
    }

    public static function getSentMessages(array $user_ids)
    {
        return Message::getSentMessages($user_ids);
    }

    public static function updateSeenMessages(array $message_ids)
    {
        return Message::updateSeenMessages($message_ids);
    }
}