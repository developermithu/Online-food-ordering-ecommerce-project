<?php 
session_start();
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$mobile      = $fm->validation($_POST['mobile']);
$password = $fm->validation($_POST['password']);
$mobile      = mysqli_real_escape_string($db->link, $mobile);
$password = mysqli_real_escape_string($db->link, $password);

if ($mobile == '') {
     echo '<div class="text-danger"><b>Mobile number must not be empty!</b></div>';
    exit();
}else if($password == ''){
			echo '<div class="text-danger"><b>Password must not be empty!</b></div>';
    exit();
}
else{
    $query = "SELECT * FROM `delivery_boy` WHERE `mobile` = '$mobile' AND `password` = '$password' ";
    $result = $db->select($query);
    if ($result == true) {
        $value = $result->fetch_assoc();
        $_SESSION['DELIVERY_BOY_LOGIN'] = 'yes';
        $_SESSION['DELIVERY_BOY_NAME'] = $value['name'];
        $_SESSION['DELIVERY_BOY_ID'] = $value['id'];
        echo 'success';
    }else{
        echo '<div class="text-danger"><b>Oops!</b> Mobile number or Password not matched.</div>';
    exit();
    }
}            
    

 ?>