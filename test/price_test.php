<?php
/**
 * Description:
 *
 * Created by PhpStorm.
 * User: Bililovy
 * Date: 2017/9/27
 * Time: 13:50
 */
$_SERVER[ 'SVCSSDK_ENV' ] = 'dev';

require __DIR__ . '/../vendor/autoload.php';
use SLD\PPNServicesSDK\V1\PriceCenterService;

$pricecenter = new PriceCenterService();

// 将币种转换封装到 此sdk，basesdk会逐步废弃
$price1 = [
    "product_id" => 47640,
    "type" => "person",
    "gross_profit" => "13.05",
    "transaction_fee" => 0,
    "adult" => "65.0000",
    "adult_cost" => "40.0000",
    "kid" => "63.0000",
    "kid_cost" => "35.0000",
    "unit" => "0.0000",
    "unit_cost" => "1.0000",
    "currency" => "USD",
    "symbol" => "$"
];

$price2 = [
    '100514' => [
        "date" => "2017-11-01",
        "date_timestamp" => 1509465600,
        "display_price" => "200.0000",
        "origin_display_price" => "200.0000",
        "adult" => "200.0000",
        "adult_cost" => "55.0000",
        "kid" => "140.0000",
        "kid_cost" => "14.0000",
        "is_holiday" => 1,
        "day_limit" => 2,
        "min_guest_number" => 1,
        "min_child_age" => 1,
        "max_child_age" => 1,
        "remaining" => -1,
        "policy_type" => "",
        "status" => "",
        "currency" => "USD",
        "symbol" => "$"
    ],
    '100152' => [
        "date" => "2017-11-02",
        "date_timestamp" => 1509552000,
        "display_price" => "65.0000",
        "origin_display_price" => "65.0000",
        "adult" => "65.0000",
        "adult_cost" => "40.0000",
        "kid" => "63.0000",
        "kid_cost" => "35.0000",
        "is_holiday" => 0,
        "day_limit" => 2,
        "min_guest_number" => 1,
        "min_child_age" => 1,
        "max_child_age" => 1,
        "remaining" => -1,
        "policy_type" => "",
        "status" => "",
        "currency" => "USD",
        "symbol" => "$",
        "extra"=>[
            'adult'=>'65',
            'kid'=>'60'
        ]
    ]
];

$priceOnly = '100';
$sourceCurrency = 'usd';
$targetCurrency = 'cny';
$priceLevel = 4;

$priceOnly = $pricecenter->exchangeCurrency($priceOnly, $sourceCurrency, $targetCurrency, $priceLevel);
var_dump($priceOnly);
echo '<hr />';
echo '<pre>';
$price1 = $pricecenter->exchangeCurrencyBatch($price1, ['adult', 'adult_cost', 'kid', 'kid_cost', 'unit', 'unit_cost'], $sourceCurrency, $targetCurrency, $priceLevel);
var_dump($price1);

$price2 = $pricecenter->exchangeCurrencyBatch($price2, ['adult', 'adult_cost', 'kid', 'kid_cost', 'unit', 'unit_cost'], $sourceCurrency, $targetCurrency, $priceLevel);
var_dump($price2);

echo $pricecenter->getCurrencySymbol($targetCurrency);
die;

// 优惠策略获取sdk
$returnFields = ['premium'];
$conditions = [
    'premium' => [
        'platform' => 'pc',
        'filter' => 1
    ]
];

$infos = $pricecenter->getPolicies($returnFields, $conditions);
echo '<pre>';
var_dump($infos);
echo '</pre>';
die;
die;
// 价格信息获取sddk
$productIds = [
    102202256,
    101687011,
    47640,
    31890,
    101458020,
    101577465,
    101577468
];
$returnFields = ['displayPrice', 'calendarPrice'];
$conditions = [
    'displayPrice' => [
        'currency' => 'cny',
        'platform' => 'pc'
    ],
    'calendarPrice' => [
        'm' => ['2017-10,2017-12'],
        'hotel' => [10101010 => 11111],
        'sku' => [354, 254],
        'currency' => 'aud',
        'platform' => 'pc',
        'show_overdate' => '1',
        'show_cp' => '0',
        'policy_contain' => '1',
        'with_price_override' => '1'
    ],
];

var_dump($pricecenter->getPriceInfos($productIds, $returnFields, $conditions, 1));

die;


