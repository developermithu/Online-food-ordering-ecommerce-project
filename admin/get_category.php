<?php 
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$catName      = $_POST['catName'];
$order_number = $_POST['order_number'];

$catName      = $fm->validation($catName);
$order_number = $fm->validation($order_number);
$catName      = mysqli_real_escape_string($db->link, $catName);
$order_number = mysqli_real_escape_string($db->link, $order_number);

if ($catName == '') {
     echo '<div class="text-danger mr-3"><b>Category name is required!</b></div>';
    exit();
}else if($order_number == ''){
			echo '<div class="text-danger mr-3"><b>Order Number is required!</b></div>';
    exit();
}
else{
   		$query = "SELECT * FROM `tbl_category` WHERE `catName` = '$catName' ";
 			$result = $db->select($query);
 			if ($result == true) {
 			echo '<div class="text-danger mr-3"><b>Category Already Added!</b></div>';
  			exit();
 			}else{
		    	$query = "INSERT INTO `tbl_category` (`catName`, `order_number`) VALUES ('$catName', '$order_number')";
		    	$result = $db->insert($query);
		    	if ($result) {
		    		echo 'success';
		    		exit();
		    	}else{
		    		echo  '<div class="text-danger mr-3"><b>Something went wrong!</b></div>';
		    		exit();
		    	}
 			}
	}            
 ?>

