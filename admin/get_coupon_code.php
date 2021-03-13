<?php 
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$coupon_code    = $_POST['coupon_code'];
$coupon_value              = $_POST['coupon_value'];
$coupon_type    =       $_POST['coupon_type'];
$cart_min_value = $_POST['cart_min_value'];
$expired_on     = $_POST['expired_on'];

$coupon_code    = $fm->validation($coupon_code);
$coupon_value   = $fm->validation($coupon_value);
$coupon_type    = $fm->validation($coupon_type);
$cart_min_value = $fm->validation($cart_min_value);
$expired_on     = $fm->validation($expired_on);

if ($coupon_code == '') {
     echo '<div class="text-danger mr-3"><b>Coupon code is required!</b></div>';
    exit();
}else if($coupon_value == ''){
			echo '<div class="text-danger mr-3"><b>Coupon value is required!</b></div>';
    exit();
}else if($coupon_type == ''){
			echo '<div class="text-danger mr-3"><b>Coupon type is required!</b></div>';
    exit();
}
else if($cart_min_value == ''){
			echo '<div class="text-danger mr-3"><b>Cart min value is required!</b></div>';
    exit();
}else if($expired_on == ''){
			echo '<div class="text-danger mr-3"><b>Expired date is required!</b></div>';
    exit();
}
else{
   		$query = "SELECT * FROM `tbl_coupon` WHERE `coupon_code` = '$coupon_code' ";
 			$result = $db->select($query);
 			if ($result == true) {
 			echo '<div class="text-danger mr-3"><b>Coupon code already added!</b></div>';
  			exit();
 			}else{
		    	$query = "INSERT INTO `tbl_coupon` (`coupon_code`, `coupon_value`, `coupon_type`, `cart_min_value`, `expired_on`) VALUES ('$coupon_code', '$coupon_value', '$coupon_type', '$cart_min_value', '$expired_on')";
		    	$result = $db->insert($query);
		    	if ($result) {
		    		echo 'added';
		    		exit();
		    	}else{
		    		echo  '<div class="text-danger mr-3"><b>Something went wrong!</b></div>';
		    		exit();
		    	}
 			}
	}            
 ?>

