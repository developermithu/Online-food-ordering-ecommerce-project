<?php
include 'inc/header.php';
include 'inc/header_bottom.php';
?>

<?php 
if ($website_close == 1) {
  echo "<script>window.location = 'shop'; </script>";
}
?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active">Cart </li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="POST">
                    <?php
                    $cartArr = getUserCartFullDetails();
                    if (count($cartArr) > 0) { ?>
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($cartArr as $key=>$value) { ?>
                                        <tr>
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="<?php echo SITE_PATH ?>admin/<?php echo $value['image'] ?>" alt="product-img"></a>
                                            </td>

                                            <td class="product-name"><a href="#"><?php echo $value['dish'] ?></a></td>

                                            <td class="product-price-cart"><span class="amount"><?php echo $value['price'] ?> tk</span></td>

                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="qty[<?php echo $key ?>][]" value="<?php echo $value['qty'] ?>">
                                                </div>
                                            </td>

                                            <td class="product-subtotal"><?php echo $value['qty'] * $value['price'] ?> tk</td>

                                            <td class="product-remove">
                                                <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key ?>', 'reload')"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="<?php echo SITE_PATH ?>shop">Continue Shopping</a>
                                    </div>
                                    <div class="cart-clear">
                                        <button name="update_cart_btn">Update Shopping Cart</button> <!-- header e update function -->
                                        <a href="<?php echo SITE_PATH ?>checkout">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                        echo '<div class="not_found">Your Cart is Empty !</div>';
                    } ?>
                </form>

            </div>
        </div>
    </div>
</div>


<?php include 'inc/footer.php' ?>