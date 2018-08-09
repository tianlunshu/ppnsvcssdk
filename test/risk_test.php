<?php
require(dirname(__FILE__) . '/vendor/autoload.php');

use SLD\PPNServicesSDK\RiskService;


$a = new RiskService();
var_dump($a->createCondition(['a' => 'b']));
var_dump($a->getErrorMessage());
