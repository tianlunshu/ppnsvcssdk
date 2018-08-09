<?php
require __DIR__.'/../vendor/autoload.php';
use SLD\PPNServicesSDK\V1\ProductCenterService;
//require_once "/home/work/env/ordersvcs/app/Utils/mteamsvcssdk/services/ProductService.php";
$_SERVER['SVCSSDK_ENV'] = 'dev';
$productService = new ProductCenterService();

$roomInfo = [
    [
        "adult"=>2,
        "child"=>1
    ],
    [
        "adult"=>1,
        "child"=>2
    ],
    [
        "adult"=>2,
        "child"=>2
    ],
    [
        "adult"=>1,
        "child"=>0
    ],
    [
        "adult"=>1,
        "child"=>0
    ]
];

$condition =
[
    [
        'checkin_date' => '2017-07-13',
        'product_id' => 102202254,
        'checkout_date' => '2017-07-14',
        'customer_info' => '1,2,9,8',
        'currency' => 'USD'
    ],
    [
        'product_id' => 101465580,
        'checkin_date' => '2017-07-13',
        'checkout_date' => '2017-07-14',
        'customer_info' => '1,2,9,8',
        'currency' => 'USD'
    ]
];

// $result = $productService->getProductAdditional(102202256, ["2018-02-01", "2018-02-03"], ["2018-02-08", "2018-02-11"], $roomInfo);
$result = $productService->getHotelsAvailabilityRoomPriceByCondition($condition, 0);
print_r($result);
