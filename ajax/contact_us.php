<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
include_once($filePath . '/../helpers/Format.php');

$db = new Database();
$fm = new Format();

$name           = $fm->validation($_POST['name']);
$email           = $fm->validation($_POST['email']);
$subject         = $fm->validation($_POST['subject']);
$message   = $fm->validation($_POST['message']);

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo 'unvalid';
    exit();
} else {

        $query = "INSERT INTO `tbl_contact` (`name`, `email`, `subject`, `message`) VALUES ('$name', '$email', '$subject', '$message')";
        $result = $db->insert($query);
        if ($result) {
            echo 'success';
            exit();
        } else {
            echo  '<span class="text-danger"><b>Something went wrong!</b></span>';
            exit();
        }
    }

