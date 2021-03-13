<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');
include_once($filePath . '/../helpers/function.php');

$db = new Database();
$fm = new Format();

$coupon_code_val = $fm->validation($_POST['coupon_code']);

$checkCode = "SELECT * FROM `tbl_coupon` WHERE `coupon_code` = '$coupon_code_val' AND `status` = '0' ";
$result = $db->select($checkCode);
if ($result == true) {
	$row = $result->fetch_assoc();
	// $coupon_code    = $row['coupon_code'];
	$coupon_value   = $row['coupon_value'];
	$coupon_type    = $row['coupon_type'];
	$cart_min_value = $row['cart_min_value'];
	$expired_on     = $row['expired_on'];
	$getCartTotalPrice = getCartTotalPrice();

	if ($getCartTotalPrice > $cart_min_value) {
		// $coupon_code_apply = 0;
		// if ($coupon_type == "Fixed") {
		// 	$coupon_code_apply = $getCartTotalPrice - $coupon_value;
		// } else {
		// 	$coupon_code_apply = $getCartTotalPrice - ($coupon_value / 100) * $getCartTotalPrice;
		// }

		$arr = array('status' => 'success', 'msg' => 'Coupon code applied successfully.',  'coupon_code_apply' => $coupon_code_apply);
	} else {
		$arr = array('status' => 'error', 'msg' => 'Total price should be greater than <b>' . $getCartTotalPrice . 'tk</b>.');
	}
} else {
	$arr = array('status' => 'error', 'msg' => '<b>Oops!</b> coupon code not found.');
}
echo json_encode($arr);
 

// $finalPrice = 0;
// if ($coupon_type == 'Fixed') {
// 	$finalPrice = $totalPrice - $coupon_value;
// }
// else  {
// 	// $Percentage = ($coupon_value/100)*$totalPrice; //(10/100) = .1*200 = 20
// 	$finalPrice = $totalPrice -(($coupon_value/100)*$totalPrice);
// }
//  $arr = array('status' => 'success', 'finalPrice' => $finalPrice, 'msg' => 'Coupon code applied successfully.' );