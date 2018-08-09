<?php
require(dirname(__FILE__) . '/../vendor/autoload.php');

use SLD\PPNServicesSDK\FinanceService;

$a = new FinanceService();
//var_dump(
//    $a->setSettlement(
//        [
//            'order_id' => 123,
//            'type' => 'receipt',
//            'payment_method_id' => 1,
//            'is_online' => 0,
//            'amount' => 88.88,
//            'user_id' => 0,
//        ]
//    ));


var_dump($a->getSettlementInvoice(1));
echo $a->getErrorMessage();
/*$r = $a->doChargeOrVoidSettlement([
    'order_id' => 670,
    'original_amount' => 40.00,
    'charge_amount' => 40.00,
    'settlement_id' => 1307,
    'pay_item_id' => 0,
]);*/


//$b = $a->createInvoice([
//    'order_id' => '1713',
//    'product_id' => '9874',
//    'amount' => 123.10,
//    'invoice_no' => '213',
//    'user_id' => 1
//]);

//$b = $a->getInvoicesByOrderProduct([
//    'order_ids' => [1713, 999],
//    'product_ids' => [9847, 100020879]
//]);

//$b = $a->createInvoice(999, 100012312, 100.00, '32198409fjw', 1);
//
//echo json_encode($b);
//
//die();
//
//$b = $a->updateInvoice(1, 2, 182, '23423eew2fjiwef', 28.00);
//
//
//echo json_encode($b);
//die();

$b = $a->getInvoicesByOrderProduct([1713, 999], [100012312, 100020879]);
echo json_encode($b);
/*echo json_encode(FinanceApiTest::$object->getRate());

$params = ['currency' => 'USD', 'begin_time' => '2016-08-16', 'end_time' => '2016-08-18'];

echo json_encode(FinanceApiTest::$object->selectUpdateLog($params));*/

