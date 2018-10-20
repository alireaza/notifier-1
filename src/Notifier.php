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
    private static $options = [];

    public static function sendPush(string $heading, string $content, array $player_ids, array $extra = null)
    {
        dispatch(new SendPushJob($heading, $content, $player_ids, $extra, static::$options));

        return true;
    }

    public static function sendSms(string $message, array $numbers)
    {
        dispatch(new SendSmsJob($message, $numbers, static::$options));

        return true;
    }

    public static function sendMessage(string $title, string $body, array $user_ids)
    {
        dispatch(new SendMessageJob($title, $body, $user_ids, static::$options));
    }

    public static function options(array $options = [])
    {
        static::$options = $options;
    }

    public static function getPushes($player_ids, string $from_datetime = null, string $to_datetime = null,
                                     $extra_field = null, array $extra_values = null)
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

    public static function getMessages(array $user_ids, string $status = null)
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