<?php
include 'inc/header.php';
include 'inc/header_bottom.php';
// echo $totalPrice;
// echo $cart_min_price;
// die();

if ($website_close == 1) {
    echo "<script>window.location = 'shop'; </script>";
}

$cartArr = getUserCartFullDetails();
if (count($cartArr) > 0) {
} else {
    echo '<script>window.location = "shop"; </script>';
}

$login = Session::get('userLogin');
if ($login == true) {
    $login_box = '';
    $login_box_id = '';
    $shipping_box = 'show';
    $shipping_box_id = 'payment-2';
} else {
    $login_box = 'show';
    $login_box_id = 'payment-1';
    $shipping_box_id = '';
}

$is_error = "";
if (isset($_POST['submit'])) {
    if ($cart_min_price != "") {
        if ($totalPrice >= $cart_min_price) {
        } else {
            $is_error = "Yes";
        }
    }

    if ($is_error == "") {
        $order = $customer->addOrderDetails($_POST, $totalPrice);
    }
}

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active"> Checkout </li>
            </ul>
        </div>
    </div>
</div>

<!-- checkout-area start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-1">Checkout method</a></h5>
                            </div>
                            <div id="<?php echo $login_box_id ?>" class="panel-collapse collapse <?php echo $login_box ?> ">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="checkout-login">
                                                <div class="title-wrap mb-4">
                                                    <h4 class="cart-bottom-title section-bg-white">LOGIN</h4>
                                                </div>

                                                <form method="post" id="login_form">

                                                    <div class="login-form">
                                                        <label>Email Address * </label>
                                                        <input type="email" id="user_email">
                                                        <div class="field_error mt-2" id="user_email_error"></div>
                                                    </div>

                                                    <div class="login-form mt-2 ">
                                                        <label>Password *</label>
                                                        <input type="password" id="user_password">
                                                        <div class="field_error mt-2" id="user_password_error"></div>
                                                    </div>
                                                </form>

                                                <div class="login-forget mt-2">
                                                    <a href="<?php echo SITE_PATH ?>forgot_password">Forgot your password?</a>
                                                    <p>* Required Fields</p>
                                                </div>

                                                <input type="hidden" id="checkout_page" value="yes">
                                                <div class="checkout-login-btn">
                                                    <a type="button" onclick="customer_login()" id="login_btn"><span>Login</span></a>
                                                    <span class="field_error ml-3" id="final_error"></span>
                                                    <a href="<?php SITE_PATH ?>login_register" class="ml-3">Register</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-2">shipping information</a></h5>
                            </div>
                            <div id="<?php echo $shipping_box_id ?>" class="panel-collapse collapse <?php echo $shipping_box ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">

                                        <?php
                                        $getUserDetails = $customer->getUserDetailsForOrder();
                                        if ($getUserDetails) {
                                            while ($user = $getUserDetails->fetch_assoc()) { ?>

                                                <form action="" method="post">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label><b>Name</b></label>
                                                                <input name="name" type="text" value="<?php echo $user['name'] ?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label><b>Email Address</b></label>
                                                                <input name="email" type="email" value="<?php echo $user['email'] ?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label><b>Mobile</b></label>
                                                                <input name="mobile" type="number" value="<?php echo $user['mobile'] ?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="billing-info">
                                                                <label><b>Zip/Post Code</b></label>
                                                                <input name="zip" type="text" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="billing-info">
                                                                <label><b>Address</b></label>
                                                                <input name="address" type="text" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="ship-wrapper">
                                                            <div class="single-ship">
                                                                <input type="radio" name="payment_type" value="cod">
                                                                <label>Cash On Delivery (COD)</label>
                                                            </div>
                                                            <div class="single-ship">
                                                                <input type="radio" name="payment_type" value="paytm" checked>
                                                                <label>PayTm</label>
                                                            </div>
                                                        </div>

                                                        <div class="billing-btn mt-2">
                                                            <button type="submit" name="submit">Submit</button>
                                                            <span class="ml-4 text-danger">
                                                                <?php
                                                                if ($is_error == "Yes") {
                                                                    echo "<b>$cart_min_price_msg</b>";
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </form>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="checkout-progress">
                    <h4>Cart Details</h4>
                    <ul id="cart_url">
                        <?php foreach ($cartArr as $key => $val) { ?>
                            <li class="single-shopping-cart d-flex justify-content-between" id="attr_<?php echo $key ?>">
                                <div class="shopping-cart-img">
                                    <a href="javascript:void(0)"><img alt="dish-img" src="<?php echo SITE_PATH ?>admin/<?php echo $val['image'] ?>"></a>
                                </div>
                                <div class="shopping-cart-title mt-4">
                                    <h4><a href="javascript:void(0)">
                                            <?php echo $val['dish'] ?>
                                        </a></h4>
                                </div>
                                <div class="shopping-cart-title mt-2">
                                    <h6>Qty: <?php echo $val['qty'] ?></h6>
                                    <span><?php echo $val['price'] * $val['qty'] ?> tk</span>
                                </div>

                            </li>
                        <?php } ?>
                        <div class="shopping-cart-total">
                            <h4><b>Shipping</b> : <span>Free</span></h4>
                            <h4><b>Total</b> : <span class="shop-total" id="shopTotal">
                                    <?php echo $totalPrice . ' tk'; ?>
                                </span></h4>
                        </div>

                        <div class="coupon-code d-flex justify-content-between mt-5">
                            <div>
                                <form action="" method="POST" id="coupon_code_form">
                                    <input type="text" placeholder="Coupon code.." id="coupon_code" name="coupon_code">
                                </form>

                            </div>
                            <div class="billing-btn">
                                <button type="button" onclick="apply_coupon()">Apply Coupon</button>
                            </div>
                        </div>
                        <span class="text-danger mt-2 d-block" id="coupon_error"></span>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'inc/footer.php' ?>