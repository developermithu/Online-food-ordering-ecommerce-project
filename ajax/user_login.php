<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');
include_once($filePath . '/../helpers/function.php');

$db = new Database();
$fm = new Format();

$user_email    = $fm->validation($_POST['user_email']);
$user_password = $fm->validation($_POST['user_password']);

if (filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
    echo 'unvalid';
    exit();
} else {
    $checkEmail = "SELECT * FROM `tbl_customer` WHERE `email` = '$user_email' ";
    $result = $db->select($checkEmail);
    if ($result == true) {
        $row = $result->fetch_assoc();
        $email_verify = $row['email_verify'];
        $encrypted_password = $row['password'];
        if ($email_verify == 1) {
            if (password_verify($user_password, $encrypted_password)) {
                Session::init();
                Session::set("userLogin", true);
                Session::set("userId", $row['id']);
                Session::set("userName", $row['name']);
                Session::set("userEmail", $row['email']);
                Session::set("userMobile", $row['mobile']);

                echo 'success';
                // user login korle unlogin er somoy cart e ja add kora ache ta database e add hobe 
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    foreach ($_SESSION['cart'] as $key => $value) {
                        $userId = Session::get('userId');
                        manageUserCart($userId, $value['qty'], $key);  //$key = attr
                    }
                }

                exit();
            } else {
                echo 'pwd_not_match';
            }
        } else {
            echo  'not_verified';
            exit();
        }
    } else {
        echo  'email_not_match';
        exit();
    }
}
