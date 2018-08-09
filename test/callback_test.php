<?php

require './vendor/autoload.php';
use TFF\Services\CallbackService as CallbackService;

$callbacker = CallbackService::init();

$callbacker->put(
    'http://api.star.admin.tff.com/hotel/order/282/book',
    [],
    CallbackService::METHOD_POST
);
