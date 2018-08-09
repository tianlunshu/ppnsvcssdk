<?php


require(dirname(__FILE__).'/vendor/autoload.php');

use SLD\PPNServicesSDK\PushService;

$_SERVER['SVCSSDK_ENV'] = 'dev';

$pushSv = PushService::getInstance();

// $res = $pushSv->sendMessage('helloNew', ['platform'=>'android'], null);
// $res = $pushSv->messageStatus(1629839775);
$res = $pushSv->deviceInfo('13065ffa4e09242df9a');
print_r($res);
var_dump($pushSv->getErrorMessage());