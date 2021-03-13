<?php
include '../lib/Session.php';
Session::checkAdminSession();
include '../lib/Database.php';
include '../helpers/Format.php';
include '../helpers/function.php';

//================ All Classes =============//
include '../classes/Category.php';
include '../classes/Customer.php';
include '../classes/Proccess.php';
include '../classes/Dish.php';

$db       = new Database();
$fm       = new Format();
$category = new Category();
$customer = new Customer();
$proccess = new Proccess();
$dish = new Dish();

?>

<?php
//======================= Meta Tag For SEO =====================//
$script_name = $_SERVER['SCRIPT_NAME'];   //  /ecomm/index.php
$script_name_arr = explode('/', $script_name);   // array
$page_name = $script_name_arr[count($script_name_arr) - 1];   // page name contact.php

$page_title = "";
if ($page_name == "" || $page_name == 'index.php') {
    $page_title = 'Dashboard | Online Food Ordering';
} else if ($page_name == "slider.php" || $page_name == 'slider_add.php') {
    $page_title = 'Manage Slider';
} else if ($page_name == "category.php" || $page_name == 'category_edit.php') {
    $page_title = 'Manage Category';
} else if ($page_name == "dish.php" || $page_name == 'dish_edit.php' || $page_name == 'dish_add.php') {
    $page_title = 'Manage Dish';
} else if ($page_name == "customer.php") {
    $page_title = 'Customer Info';
} else if ($page_name == "order.php") {
    $page_title = 'Manage Customer Order';
}else if ($page_name == "delivery_boy.php" || $page_name == 'delivery_boy_edit.php') {
    $page_title = 'Manage Delivery Boy';
} else if ($page_name == "coupon_code.php" || $page_name == 'coupon_code_edit.php') {
    $page_title = 'Manage Coupon Code';
} else if ($page_name == "setting.php") {
    $page_title = 'Manage Website Setting';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title><?php echo $page_title; ?></title>

    <!-- Fontfaces CSS-->
    <link href="assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- assets/Vendor CSS-->
    <link href="assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <!-- Main CSS-->
    <link href="assets/css/theme.css" rel="stylesheet" media="all">
    <link href="assets/css/custom.css" rel="stylesheet" media="all">

</head>

<body class="animsition" style="animation-duration: 0ms !important;">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.php">
                            <img src="assets/images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="table.php">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>
                        <li>
                            <a href="form.php">
                                <i class="far fa-check-square"></i>Forms</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="login.php">Login</a>
                                </li>
                                <li>
                                    <a href="register.php">Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.php">Forget Password</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->