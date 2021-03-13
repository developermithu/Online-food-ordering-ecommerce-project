<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
Session::init();
include_once($filePath . '/../helpers/Format.php');
include_once($filePath . '/../helpers/function.php');

$db = new Database();
$fm = new Format();

$old_pwd = $fm->validation($_POST['old_pwd']);
$new_pwd = $fm->validation($_POST['new_pwd']);
$userId  = Session::get('userId');

$query  = "SELECT `password` FROM `tbl_customer` WHERE `id` = '$userId' ";
$result = $db->select($query);

$row = $result->fetch_assoc();
$dbPassword = $row['password'];
    if (password_verify($old_pwd, $dbPassword)) {
        $new_pwd = password_hash($new_pwd, PASSWORD_BCRYPT);
        $query = "UPDATE `tbl_customer` SET `password` = '$new_pwd' WHERE `id` = '$userId' ";
        $result = $db->update($query);
            echo 'success';
            exit();
    }else{
        echo  'pwd_not_match';
        exit();
    }
    

    






