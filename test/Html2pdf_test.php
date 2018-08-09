<?php

require __DIR__.'/vendor/autoload.php';
use SLD\PPNServicesSDK\Html2pdfService;

$_SERVER['SVCSSDK_ENV'] = 'dev';

$hotel = Html2pdfService::init();
$result = $hotel->test('','http://www.baidu.com/');
if (is_array($result) && isset($result['code']) && $result['code'] == 0) {
    header("Content-type:application/pdf");
    echo base64_decode($result['data']);
} else {
    echo 'error:',print_r($result, true);
}