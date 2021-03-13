<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

include_once($filePath . '/../smtp/PHPMailerAutoload.php');

$db = new Database();
$fm = new Format();

$regName           = $fm->validation($_POST['regName']);
$regEmail           = $fm->validation($_POST['regEmail']);
$regMobile         = $fm->validation($_POST['regMobile']);
$regPassword   = $fm->validation($_POST['regPassword']);

if (filter_var($regEmail, FILTER_VALIDATE_EMAIL) === false) {
    echo 'unvalid';
    exit();
} else {

    $checkEmail = "SELECT * FROM `tbl_customer` WHERE `email` = '$regEmail' ";
    $result = $db->select($checkEmail);
    if ($result == true) {
        echo 'exist';
        exit();
    } else {
        $encrypted_password = password_hash($regPassword, PASSWORD_BCRYPT);
        $rand_string = $fm->rand_string();
        $query = "INSERT INTO `tbl_customer` (`name`, `email`, `mobile`, `password`, `rand_string`) VALUES ('$regName', '$regEmail', '$regMobile', '$encrypted_password', '$rand_string')";
        $result = $db->insert($query);
        if ($result) {
            // $id = mysqli_insert_id($db->link);
            //verify_email.php?verify_id=' . $rand_string;   for seo check .htaccess
            $html = 'http://localhost/food/verify_email?verify_id=' . $rand_string;
            $fm->send_email($regEmail, $html, 'Verify your email.');
            echo 'success';
            exit();
        } else {
            echo  '<span class="text-danger"><b>Something went wrong!</b></span>';
            exit();
        }
    }
}
