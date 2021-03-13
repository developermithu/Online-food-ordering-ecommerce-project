<?php
include 'lib/Session.php';
Session::init();
include 'lib/Database.php';
include 'helpers/Format.php';
include 'helpers/function.php';

include 'smtp/PHPMailerAutoload.php';

$db = new Database();
$fm = new Format();

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./paytm_lib/config_paytm.php");
require_once("./paytm_lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if ($isValidChecksum == "TRUE") {
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		$oid = $_POST['ORDERID'];  //{$insert_id .'_'.$userId;}
		$oidArr = explode('_', $oid);
		$oid = $oidArr[0];
		$email = Session::get('userEmail');
		$html  = orderEmail($oid);
		$_SESSION['ORDER_ID'] = $oid;
		$TXNID = $_POST['TXNID'];

		$query = "UPDATE `tbl_order` SET `payment_status` = 'Success', `payment_id` = '$TXNID' WHERE `id` = '$oid' ";
		$db->update($query);

		// $fm->send_email($email, $html, 'Order Placed With PayTm');  //must be include smtp file
		echo '<script>window.location = "success"; </script>';
	} else {
		$oid = $_POST['ORDERID'];  //{$insert_id .'_'.$userId;}
		$oidArr = explode('_', $oid);
		$oid = $oidArr[0];
		$TXNID = $_POST['TXNID'];

		$query = "UPDATE `tbl_order` SET `payment_status` = 'Failed', `payment_id` = '$TXNID' WHERE `id` = '$oid' ";
		$db->update($query);

		echo '<script>window.location = "error"; </script>';
	}
} else {
	$oid = $_POST['ORDERID'];  //{$insert_id .'_'.$userId;}
	$oidArr = explode('_', $oid);
	$oid = $oidArr[0];
	$TXNID = $_POST['TXNID'];

	$query = "UPDATE `tbl_order` SET `payment_status` = 'Failed', `payment_id` = '$TXNID' WHERE `id` = '$oid' ";
	$db->update($query);

	echo '<script>window.location = "error"; </script>';
}
