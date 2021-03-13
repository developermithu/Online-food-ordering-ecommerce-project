<?php 
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$updateCatname     = $_POST['updateCatname'];
$updateOrdernumber = $_POST['updateOrdernumber']; 
$hidden_id = $_POST['hidden_id']; 

$updateCatname     = $fm->validation($updateCatname);
$updateOrdernumber = $fm->validation($updateOrdernumber);
$updateCatname     = mysqli_real_escape_string($db->link, $updateCatname);
$updateOrdernumber = mysqli_real_escape_string($db->link, $updateOrdernumber);

if ($updateCatname == '') {
     echo '<span class="text-danger"><b>Category name is required!</b></span>';
    exit();
}else if($updateOrdernumber == ''){
			echo '<span class="text-danger"><b>Order Number is required!</b></span>';
    exit();
}
else{	
	   		$query = "UPDATE `tbl_category` SET `catName` = '$updateCatname', `order_number` = '$updateOrdernumber' WHERE `id` = '$hidden_id' ";
	 			$result = $db->update($query);
	 			if ($result == true) {
	 			echo 'updated';
	 			exit();
	 			}else{
	 					echo '<span class="text-danger"><b>Something went wrong!</b></span>';
			    		exit();
	 			}
	 		}
?>
