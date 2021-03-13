<?php
include 'lib/Session.php';
Session::init();
include 'lib/Database.php';
include 'helpers/Format.php';
include 'helpers/function.php';

require_once 'mpdf/vendor/autoload.php';

$db       = new Database();
$fm       = new Format();

$userLogin  = Session::get('userLogin');
$adminLogin = Session::get("adminLogin"); //admin Login 
$userId     = Session::get("userId"); //user Login id

if ($adminLogin == true) {
} else {
	if ($userLogin != true) {
		echo '<script>window.location = "index"; </script>';
	}
}

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = $fm->validation($_GET['id']);

	if ($adminLogin == true) {
	} else {
		$query = "SELECT * FROM `tbl_order` WHERE `user_id` = '$id' ";
		$result = $db->select($query);
		if ($result) {
			$checkUser = $result->fetch_assoc();
			if ($checkUser['user_id'] != $userId) {
				echo '<script>window.location = "index"; </script>';
			}
		}
	}

	$orderEmail = orderEmail($id);

	$mpdf = new \Mpdf\Mpdf();
	$mpdf->WriteHTML($orderEmail);
	$file = time() . '.pdf';
	$mpdf->Output($file, 'D'); // D means forcefully download
}
