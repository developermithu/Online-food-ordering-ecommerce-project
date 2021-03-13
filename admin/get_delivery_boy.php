<?php 
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$name     = $_POST['name'];
$mobile   = $_POST['mobile'];
$password = $_POST['password'];

$name     = $fm->validation($name);
$mobile   = $fm->validation($mobile);
$password = $fm->validation($password);

if ($name == '') {
     echo '<div class="text-danger mr-3"><b>Delivery boy name is required!</b></div>';
    exit();
}else if($mobile == ''){
			echo '<div class="text-danger mr-3"><b>Mobile number is required!</b></div>';
    exit();
}else if($password == ''){
			echo '<div class="text-danger mr-3"><b>Password is required!</b></div>';
    exit();
}
else{
   		$query = "SELECT * FROM `delivery_boy` WHERE `mobile` = '$mobile' ";
 			$result = $db->select($query);
 			if ($result == true) {
 			echo '<div class="text-danger mr-3"><b>Delivery Boy Already Added!</b></div>';
  			exit();
 			}else{
		    	$query = "INSERT INTO `delivery_boy` (`name`, `mobile`, `password`) VALUES ('$name', '$mobile', '$password')";
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

