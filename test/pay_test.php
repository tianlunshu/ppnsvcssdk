<?php
require(dirname(__FILE__) . '/vendor/autoload.php');

use SLD\PPNServicesSDK\PaymentService;

$payment = new PaymentService();

$biz_content = [
    'out_trade_no' => '23413',
    'subject' => '乞力马扎罗山五日穷游',
    'total_amounts' => [
        'CNY' => '0.01',
        'USD' => '0.06'
    ],
    'expired_time' => '30',
    'return_url' => 'http:\/\/www.tff.com\/account_history.php',
    'notify_url' => 'http:\/\/www.tff.com\/cart\/payNotify\/',
    'data' => [
        'data1' => 'value1'
    ],
    'channel_data' => [
        'CCBFQ' => [
            'is_free' => false
        ],
        'SHOUFUYOU' => [
            'name' => 'zhangsan|lisi',
            'departure' => '上海',
            'departure_date' => '2016-6-13'
        ]
    ]
];
var_dump($payment->getPayFLowLog(0));
var_dump($payment->data);
echo $payment->getErrorMessage();
die();
var_dump($payment->getTradeNo('pc', $biz_content));
die();
//echo $biz_content;die();
/* $url = $payment->getTradeNo('23',$biz_content);
$payment->pay($url['trade_no']);*/
var_dump($payment->payByAuthorize(['23']));
die();
var_dump($payment->getPayResult('20000630203301065548'));
