<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');
// smtp
include_once($filePath . '/../smtp/PHPMailerAutoload.php');

$db = new Database();
$fm = new Format();

$email  = $fm->validation($_POST['email']);

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo 'unvalid';
    exit();
} else {
    $checkEmail = "SELECT * FROM `tbl_customer` WHERE `email` = '$email' ";
    $result = $db->select($checkEmail);
    if ($result == true) {
        $row = $result->fetch_assoc();
        $email_verify = $row['email_verify'];
        $id = $row['id'];
        if ($email_verify == 1) {
            $rand_pwd = rand(111111, 999999);
            $new_pwd = password_hash($rand_pwd, PASSWORD_BCRYPT);
            $query = "UPDATE `tbl_customer` SET `password` = '$new_pwd' WHERE `id` = '$id' ";
            $result = $db->update($query);
            $html = 'Your new password is <b>' .$rand_pwd. '</b>';
            $fm->send_email($email, $html, 'New Password');
            echo  'success';
            exit();
        } else {
            echo  'not_verified';
            exit();
        }
    } else {
        echo  'email_not_match';
        exit();
    }
}
