<?php
include 'inc/header.php';
include 'inc/header_bottom.php';
?>

<?php 
    $login = Session::get('userLogin');
if ($login == false) {
    echo '<script>window.location = "index"; </script>';
}
?>

<?php 
if (isset($_GET['cancel_id'])) {
   $cancel_id = $fm->validation($_GET['cancel_id']);
    $cancel_at = date('Y-m-d h:i:s');
    $uid = Session::get('userId');

   $query = "UPDATE `tbl_order` SET `order_status` = '5', `cancel_by` = 'user', `cancel_at` = '$cancel_at' WHERE `id` = '$cancel_id' AND `order_status` = 1 AND  `user_id` = '$uid' ";
    $db->update($query);
    echo '<script>window.location = "order_history"; </script>';
}
?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active">Order History </li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Your last order history</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive wishlist">
                        <table>
                            <thead>
                                <tr class=" text-center">
                                    <th>Order No</th>
                                    <th>Name / Email / Mobile</th>
                                    <th>Address / Zipcode</th>
                                    <th>Total Price</th>
                                    <th>Order Details</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orderDetails = $customer->getOrderDetails();
                                if ($orderDetails) {
                                    while ($row = $orderDetails->fetch_assoc()) {
                                ?>

                                        <tr class="text-center">
                                            <td class="product-wishlist-cart"><?php echo $row['id'] ?><br><br>
                                                <a href="download_invoice?id=<?php echo $row['id'] ?>">Pdf</a>
                                            </td>
                                            <td>
                                                <?php echo $row['name'] ?>
                                                <?php echo $row['email'] ?><br>
                                                <?php echo $row['mobile'] ?><br>
                                            </td>
                                            <td>
                                                <?php echo $row['address'] ?>
                                                <p><?php echo $row['zip'] ?></p>
                                            </td>

                                            <td><?php echo $row['total_price'] ?> tk</td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <th>Dish</th>
                                                        <th>Attribute</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                    <?php
                                                    $getOrderDetails = getOrderDetails($row['id']); //function
                                                    foreach ($getOrderDetails as $list) { ?>
                                                        <tr>
                                                            <td><?php echo $list['dish'] ?></td>
                                                            <td><?php echo $list['attribute'] ?></td>
                                                            <td><?php echo $list['price'] ?>tk</td>
                                                            <td><?php echo $list['qty'] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                            <td>
                                                <div class="payment_status_<?php echo $row['payment_status'] ?>">
                                                    <?php echo $row['payment_status'] ?>
                                                </div>
                                            </td>
                                            <td><?php echo $row['order_status_name']
                                            ?><br>
                                            <?php 
                                            if ($row['order_status'] == 1) { ?>
                                           <a href="?cancel_id=<?php echo $row['id']?>" class="btn btn-danger  mt-2">Cancel</a>
                                           <?php } ?>
                                        </td>
                                            <td><?php echo $row['added_on'] ?></td>
                                        </tr>
                                <?php }
                                } else {
                                    echo '<td colspan="8" class="not_found">Data not found!</td>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php' ?>