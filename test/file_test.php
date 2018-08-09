<html>
<head>


</head>

<body>

<form method="post" action="file_test.php" enctype="multipart/form-data">
	<input type="file" name="file" id="f2">
	<input type="submit" name="submit">
</form>

</body>

</html>


<?php

require(dirname(__FILE__).'/../vendor/autoload.php');

use SLD\PPNServicesSDK\FileService;

$_SERVER['SVCSSDK_ENV'] = 'qa';
$fileSv = FileService::getInstance();
// $result = $fileSv->getUploadLimit();
// $result = $fileSv->uploadFileStream(file_get_contents('/Users/zhouli/www/1.txt'), 'jpg', 0);
// $result = $fileSv->getUrls('all');
// $result = $fileSv->uploadLocalFile('/Users/zhouli/www/tf/test/test.php', 0, 'phpdir');
// $result = $fileSv->uploadFile('file', 1, 'jpg');
// $result = $fileSv->uploadHtml('{"store_id":7,"customer_id":1264636,"book_platform":1,"note_info":"\u6d4b\u8bd5\u8ba2\u5355","customer_id_list":[{"customer_id":1264636}],"priority":1,"device_info":{"platform":"app"},"product_list":[{"product_id":"101464731","policy_info":{"promo_code":"","currency":"USD","order_amount":680},"product_line":"tour","subscriber_info":[{"mobile":"86-13312345678","telephone":"86-13222334456","firstname_en":"zhang","lastname_en":"san","gender":"1","email":"safsf@124.com","country_code":"86"}],"guest_info":[{"type":"adult","lastname_en":"li","firstname_en":"si"},{"type":"child","lastname_en":"wang","firstname_en":"wu"}],"travel_info":{"departure_date":"2017-04-25","departure_week":0,"departure_time":"","departure_location":"safasfsfasdfasdfsf","end_date":"2017-04-28","room_info":[{"adult":"1","child":"1"}]},"price_info":{"product_id":"101464731","product_line":"tour","currency":"USD","room":[{"adult":2,"child":0,"sum":680,"sum_cost":2,"sum_diplay":"680.00","sum_cost_diplay":"2.00"}],"upgrades":[{"title":"\u673a\u573a\u63a5\u9a73","list":[{"total":"+0.00","total_cost":"+0.00","name":"8:30am-11:00pm \u514d\u8d39\u63a5\u673a","total_display":"0.00","total_cost_display":"0.00"}]},{"title":"\u79bb\u56e2\u57ce\u5e02","list":[{"total":"+0.00","total_cost":"+0.00","name":"\u534e\u76db\u987f","total_display":"0.00","total_cost_display":"0.00"}]}],"product_price":"680.00","product_base_price":680,"product_upgrade_price":0,"product_cost_price":2,"product_upgrade_cost":0,"product_final_cost_price":2,"discount_info":{"name":"","type":"","price":0,"price_usd":0},"product_final_price":680,"product_final_price_display":"680.00","product_final_price_usd":"680.00","product_base_price_display":"680.00","product_upgrade_price_display":"0.00","product_cost_price_display":"2.00","product_upgrade_cost_display":"0.00","product_price_display":680,"product_final_cost_price_usd":"2.00","product_final_cost_price_display":2},"attribute_info":[{"upgrade_id":"111930","option_id":"3690"},{"upgrade_id":"111933","option_id":"3723"}]}],"pay_info":{"retail":680,"cost":2,"final_retail":680,"discount":0,"discount_order":{"points":"0"},"limit_pay":[],"base_info":{"platform":"mobile","user_id":1264636,"user_level":0},"pay_items":[{"customer_id":1264636,"need_pay":680}]},"policy":"[]","is_effective":0}', 1, 'pdf', 'error');
print_r($result);
print_r($fileSv->getErrorMessage());
?>
