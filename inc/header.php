<?php
include 'lib/Session.php';
Session::init();
include 'lib/Database.php';
include 'helpers/Format.php';
include 'helpers/function.php';

//================ All Classes =============//
include 'classes/Category.php';
include 'classes/Customer.php';
include 'classes/Proccess.php';
include 'classes/Dish.php';

$db       = new Database();
$fm       = new Format();
$category = new Category();
$customer = new Customer();
$proccess = new Proccess();
$dish = new Dish();

$totalPrice = 0;
getDishCartStatus();
$getSetting = getsetting();
$cart_min_price           = $getSetting['cart_min_price'];
$cart_min_price_msg = $getSetting['cart_min_price_msg'];
$website_close           = $getSetting['website_close'];
$website_close_msg = $getSetting['website_close_msg'];

// Cart Update $cartarr er upor likhte hobe header o update hower jonno 
if (isset($_POST['update_cart_btn'])) {
    foreach ($_POST['qty'] as $key => $value) {
        $login   = Session::get('userLogin');
        $userId = Session::get('userId');
        if ($login == true) {
            if ($value[0] == 0) {
                $query = "DELETE FROM `tbl_cart` WHERE `dish_details_id` = '$key' AND `user_id` = '$userId' ";
                $db->delete($query);
            } else {
                $query = "UPDATE `tbl_cart` SET `qty` = '" . $value[0] . "' WHERE `dish_details_id` = '$key' AND `user_id` = '$userId' ";
                $db->update($query);
            }
        } else {
            if ($value[0] == 0) {
                unset($_SESSION['cart'][$key]['qty']);
            } else {
                $_SESSION['cart'][$key]['qty'] = $value[0];
            }
        }
    }
}

$cartArr = getUserCartFullDetails();
$totalPrice = getCartTotalPrice();
$totalCartNumber = count($cartArr);
?>

<!--=================  Meta Tag For SEO  ================-->
<?php
$script_name = $_SERVER['SCRIPT_NAME'];   //  /ecomm/index.php
$script_name_arr = explode('/', $script_name);   // array
$page_name = $script_name_arr[count($script_name_arr) - 1];   // page name contact.php

$page_title = "";
if ($page_name == "" || $page_name == 'index.php') {
    $page_title = 'Foody - Online Food Ordering Website | Developed By Mithu';
} else if ($page_name == "about-us.php") {
    $page_title = 'Foody | About Us';
} else if ($page_name == "contact-us.php") {
    $page_title = 'Foody | Contact Us';
} else if ($page_name == "wishlist.php") {
    $page_title = 'Foody | My Wishlist';
} else if ($page_name == "cart.php") {
    $page_title = 'Foody | My Cart List';
} else if ($page_name == "checkout.php") {
    $page_title = 'Foody | Checkout';
} else if ($page_name == "forgot_password.php") {
    $page_title = 'Foody | Reset My Password ';
} else if ($page_name == "login_register.php") {
    $page_title = 'Foody | Login/Register';
} else if ($page_name == "my_account.php") {
    $page_title = 'Foody | My Account';
} else if ($page_name == "order_history.php") {
    $page_title = 'Foody | My Order History';
} else if ($page_name == "shop.php") {
    $page_title = 'Foody | Shop';
} else if ($page_name == "success.php") {
    $page_title = 'Foody | Order Success';
} else if ($page_name == "product_details.php") {
    $product_id = $_GET['id'];
    $query = "SELECT * FROM `tbl_dish` WHERE `id` = '$product_id'";
    $result = $db->select($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $page_title         = $row['dish'];
        //    $meta_desc       = $row['meta_desc'];
        //    $meta_keyword = $row['meta_keyword'];
    }
}


?>
<!--=================  Meta Tag For SEO  ================-->

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $page_title ?></title>
    <meta name="description" content="Foody is a online food ordering ecommerce website which is developed by mithu.">
    <meta name="keywords" content="food, foody, food ordering, ecommerce, mithu, developermithu, mrittunjoyi mithu, mithu105 ">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo SITE_PATH ?>media/icon.jpg">

    <!-- all css here -->
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/slick.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/chosen.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/responsive.css">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/custom.css">
    <script src="<?php echo SITE_PATH ?>assets/js/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- header start -->
    <header class="header-area">
        <div class="header-top black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                        <div class="welcome-area">
                            <p>Welcome
                                <span style="color: #ec0057 ">
                                    <?php
                                    $login = Session::get('userLogin');
                                    if ($login == true) {
                                        echo Session::get('userName');
                                    } else {
                                        echo 'Gust';
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                        <div class="account-curr-lang-wrap f-right">
                            <ul>
                                <li class="top-hover"><a href="#">Language: (Eng)
                                        <i class="fas fa-chevron-down"></i></a>
                                    <ul>
                                        <li><a href="#">Bangla </a></li>
                                        <li><a href="#">English </a></li>
                                    </ul>
                                </li>
                                <li class="top-hover"><a href="#">Setting
                                        <i class="fas fa-chevron-down"></i></a>
                                    <ul>
                                        <?php
                                        if (isset($_GET['action'])) {
                                            Session::destroy();
                                            echo '<script>window.location = "index"; </script>';
                                        }
                                        $login = Session::get('userLogin');
                                        if ($login == true) { ?>
                                            <li><a href="<?php echo SITE_PATH ?>wishlist">Wishlist </a></li>
                                            <li><a href="<?php echo SITE_PATH ?>my_account">my account</a></li>
                                            <li><a href="<?php echo SITE_PATH ?>order_history">Order history</a></li>
                                            <li><a href="?action=logout">logout</a></li>

                                        <?php   } else { ?>
                                            <li><a href="<?php echo SITE_PATH ?>login_register">Login</a></li>
                                            <li><a href="<?php echo SITE_PATH ?>login_register">Register</a></li>
                                        <?php  } ?>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                        <div class="logo">
                            <a href="<?php echo SITE_PATH ?>">
                                <img alt="" src="<?php echo SITE_PATH ?>enjoy.png">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                        <div class="header-middle-right f-right">
                            <div class="header-login">
                                <?php
                                $login = Session::get('userLogin');
                                if ($login == false) { ?>
                                    <a href="login_register">
                                        <div class="header-icon-style">
                                            <!-- <i class="icon-user icons"></i> -->
                                            <!-- <ion-icon name="person-outline" class=" fa-3x"></ion-icon> -->
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="login-text-content">
                                            <p>Register <br> or <span>Sign in</span></p>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>

                            <div class="header-wishlist">
                                <?php
                                $login = Session::get('userLogin');
                                if ($login == true) { ?>
                                    <a href="<?php echo SITE_PATH ?>wishlist">
                                        <div class="header-icon-style">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div class="wishlist-text">
                                            <p>Your Wishlist</p>
                                        </div>
                                    </a>
                                <?php   } ?>
                            </div>

                            <div class="header-cart">
                                <a href="#">
                                    <div class="header-icon-style">
                                        <!-- <ion-icon name="cart-outline" class=" fa-3x"></ion-icon> -->
                                        <i class="fas fa-shopping-cart    "></i>
                                        <span class="count-style" id="totalCartNumber">
                                            <?php echo $totalCartNumber; ?>
                                        </span>
                                    </div>
                                    <div class="cart-text">
                                        <span class="digit">My Cart</span>
                                        <span class="cart-digit-bold" id="totalPrice">
                                            <?php
                                            if ($totalPrice != 0) {
                                                echo $totalPrice . ' tk';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </a>

                                <?php
                                if ($totalPrice != 0) { ?>
                                    <div class="shopping-cart-content">
                                        <ul id="cart_url">
                                            <?php foreach ($cartArr as $key => $val) { ?>
                                                <li class="single-shopping-cart" id="attr_<?php echo $key ?>">
                                                    <div class="shopping-cart-img">
                                                        <a href="javascript:void(0)"><img alt="dish-img" src="<?php echo SITE_PATH ?>admin/<?php echo $val['image'] ?>"></a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4><a href="javascript:void(0)">
                                                                <?php echo $val['dish'] ?>
                                                            </a></h4>
                                                        <h6>Qty: <?php echo $val['qty'] ?></h6>
                                                        <span><?php echo $val['price'] * $val['qty'] ?> tk</span>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key ?>')"><i class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="shopping-cart-total">
                                            <h4>Shipping : <span>Free</span></h4>
                                            <h4>Total : <span class="shop-total" id="shopTotal">
                                                    <?php echo $totalPrice . ' tk'; ?>
                                                </span></h4>
                                        </div>
                                        <div class="shopping-cart-btn">
                                            <a href="<?php echo SITE_PATH ?>cart">View Cart</a>
                                            <a href="<?php echo SITE_PATH ?>checkout">Checkout</a>
                                        </div>
                                    </div>
                                <?php }  ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>