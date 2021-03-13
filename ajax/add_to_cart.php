<?php
$filePath = realpath(dirname(__FILE__));
include_once($filePath . '/../lib/Database.php');
include_once($filePath . '/../lib/Session.php');
Session::init();
include_once($filePath . '/../helpers/Format.php');
include_once($filePath . '/../helpers/function.php');

$db = new Database();
$fm = new Format();

$attr   = $fm->validation($_POST['attr']);
$type = $fm->validation($_POST['type']);

if ($type == 'add') {
    $qty    = $fm->validation($_POST['qty']);

    $login = Session::get('userLogin');
    if ($login == true) {  // login kora thakle database e add hobe
        $userId =  Session::get('userId');
        manageUserCart($userId, $qty, $attr);
    } else { // login kora na thakle session e add hobe
        $_SESSION['cart'][$attr]['qty'] = $qty;
    }

    $getUserCartFullDetails = getUserCartFullDetails();
    $totalPrice = 0;
    foreach ($getUserCartFullDetails as $value) {
        $totalPrice = $totalPrice + ($value['qty'] * $value['price']);
    }

    $dishDetails = getDishDetailsById($attr);
    $price        = $dishDetails['price'];
    $name       = $dishDetails['dish'];
    $image      = $dishDetails['image'];
    $totalCart = count(getUserCartFullDetails());
    $arr = array('totalCartNumber' => $totalCart, 'totalPrice' => $totalPrice, 'price' => $price, 'name' => $name, 'image' => $image);
    echo json_encode($arr);
}

if ($type == 'delete') {
    removeCartById($attr);
    $getUserCartFullDetails = getUserCartFullDetails();
    $totalCart = count($getUserCartFullDetails);
    $totalPrice = 0;
    foreach ($getUserCartFullDetails as $value) {
        $totalPrice = $totalPrice + ($value['qty'] * $value['price']);
    }
    $arr = array('totalCartNumber' => $totalCart, 'totalPrice' => $totalPrice);
    echo json_encode($arr);
}
