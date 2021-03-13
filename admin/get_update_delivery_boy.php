<?php 
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$name   = $_POST['name'];
$mobile = $_POST['mobile']; 
$hidden_id = $_POST['hidden_id']; 

$name   = $fm->validation($name);
$mobile = $fm->validation($mobile);

if ($name == '') {
     echo '<span class="text-danger"><b>Delivery boy name is required!</b></span>';
    exit();
}else if($mobile == ''){
			echo '<span class="text-danger"><b>Mobile number is required!</b></span>';
    exit();
}
else{	
	   		$query = "UPDATE `delivery_boy` SET `name` = '$name', `mobile` = '$mobile' WHERE `id` = '$hidden_id' ";
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
