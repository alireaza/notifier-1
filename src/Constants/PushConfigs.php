<?php

namespace Asanbar\Notifier\Constants;

class PushConfigs
{
    const ONESIGNAL_URI = "https://onesignal.com/api/v1/notifications";
    const ONESIGNAL_APP_ID = "ecb8be7c-f1f5-47ca-95c1-a8949113c0bd";
    const ONESIGNAL_AUTHORIZATION = "MGQ5OTEzZWYtN2EwNC00YjIyLWI4MGYtNWM1NzBhNWU0ZmYy";

    const CHABOK_URL_DEV = "https://sandbox.push.adpdigital.com/api/";
    const CHABOK_URL = "https://".self::CHABOK_APP_ID.".push.adpdigital.com/api/";
    const CHABOK_APP_ID = "asanbar-broker";
    const CHABOK_ACCESS_TOKEN = "f2955e984cad56fd9527680b50f49c6e2140239b";
    
}