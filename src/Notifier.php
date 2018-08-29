<?php

namespace Asanbar\Notifier;

use App\Http\Controllers\Controller;
use Asanbar\Notifier\Constants\Message;
use Asanbar\Notifier\Jobs\SendPushJob;
use Asanbar\Notifier\Jobs\SendSmsJob;
use Asanbar\Notifier\NotificationProviders\PushProviders\OneSignal\OneSignalProvider;
use Asanbar\Notifier\NotificationProviders\PushProviders\PushAbstract;
use Asanbar\Notifier\NotificationProviders\SmsProviders\SmsIr\SmsIrProvider;
use Illuminate\Http\Request;
use Asanbar\Notifier\NotificationProviders\PushProviders\Chabok\ChabokProvider;

class Notifier
{
    public static function sendPush(string $heading, string $content, array $player_ids, array $extra = null)
    {
        // dispatch(new SendPushJob(new OneSignalProvider(), $heading, $content, $player_ids, $extra));
        dispatch(new SendPushJob(new ChabokProvider(), $heading, $content, $player_ids, $extra));

        return true;
    }

    public static function sendSms(array $messages, array $numbers, string $datetime = null)
    {

        dispatch(new SendSmsJob(new SmsIrProvider(), $messages, $numbers, $datetime));

        return true;
    }
}