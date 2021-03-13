<?php 

$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$username = $_POST['username'];
$password = $_POST['password'];

$username = $fm->validation($username);
$password = $fm->validation($password);
$username = mysqli_real_escape_string($db->link, $username);
$password = mysqli_real_escape_string($db->link, $password);
if ($username == '') {
     echo '<div class="text-danger"><b>Username must not be empty!</b></div>';
    exit();
}else if($password == ''){
			echo '<div class="text-danger"><b>Password must not be empty!</b></div>';
    exit();
}
else{
    $query = "SELECT * FROM `tbl_admin` WHERE `username` = '$username' AND `password` = '$password' ";
    $result = $db->select($query);
    if ($result == true) {
        $value = $result->fetch_assoc();
        Session::init();
        Session::set("adminLogin", true);
        Session::set("adminid", $value['id']);
        Session::set("adminName", $value['name']);
        Session::set("adminEmail", $value['email']);
        Session::set("adminPassword", $value['password']);
        Session::set("adminUsername", $value['username']);
        echo 'success';
    }else{
        echo '<div class="text-danger"><b>Oops!</b> Username or Password not matched.</div>';
    exit();
    }
}            
    

 ?>