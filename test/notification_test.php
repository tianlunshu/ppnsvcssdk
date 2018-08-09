<?php

require './vendor/autoload.php';
use TFF\Services\NotificationService as Notification;

function sms ($num)
{
    $test = Notification::init();
    print_r($test->sendSms($num, '【途风旅游网】test',Notification::TYPE_NORMAL, false, Notification::SMS_PROVIDER_NEXMO));
}

function email ($email)
{
    $test = Notification::init();
    print_r($test->sendMail($email, '【途风旅游网】test', 'aaa', Notification::TYPE_NORMAL , false, 'mytest'));
}
sms("8618628234541");
//email(["star.yu@toursforfun.cn"]);