<style>
    .header-desktop{
        left: 0px !important;
    }
    .page-container{
        padding-left: 0px !important;
    }
</style>
<?php include 'inc/header.php' ?>

<?php 
if (isset($_GET['set_delivered_id'])) {
    $delivered_id = $_GET['set_delivered_id'];
    $id =  $_SESSION['DELIVERY_BOY_ID'];
    $delivered_on = date('Y-m-d h:i:s');
    $query = "UPDATE `tbl_order` SET `order_status` = '4',  `delivered_on` = '$delivered_on' WHERE `id` = '$delivered_id' AND `delivery_boy_id` = '$id' ";
    $db->update($query);
}
?>

<div class="page-container">
    <!-- HEADER DESKTOP-->

    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">

                    <div class="header-button">
                        <div class="account-wrap">
                            <div class="account-item clearfix js-item-menu">
                                <div class="image">
                                    <img src="../admin/assets/images/icon/avatar-01.jpg" alt="John Doe" />
                                </div>
                                <div class="content">
                                    <span class="js-acc-btn" href="#">
                                        <?php
                                        if (isset($_SESSION['DELIVERY_BOY_LOGIN'])) {
                                            echo $_SESSION['DELIVERY_BOY_NAME'];
                                        } else {
                                            echo 'Jhon Doe';
                                        }
                                        ?>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
                        unset($_SESSION['DELIVERY_BOY_LOGIN']);
                       echo '<script>window.location = "login.php"; </script>';
                    }
                    ?>
                    <div class="header-button ml-auto">
                        <a href="?action=logout">Logout</a>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <!-- HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Order List</h2>
                        </div>
                    </div>
                </div>

                <div class="row m-t-30">
                    <div class="col-md-12">
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                            <table class="table table-data3" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Name / Email / Mobile</th>
                                        <th>Address / Zip</th>
                                        <th>Price</th>
                                        <th>Payment Status</th>
                                        <th>Payment Type</th>
                                        <th>Order Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $deliveryBoyId = $_SESSION['DELIVERY_BOY_ID'];
                                    $orderDetails = $customer->getOrderDetailsByDeliveryBoyId($deliveryBoyId);
                                    if ($orderDetails) {
                                        while ($row = $orderDetails->fetch_assoc()) {
                                    ?>

                                            <tr class="text-center">
                                                <td><?php echo $row['id'] ?></td>
                                                <td>
                                                    <?php echo $row['name'] ?>
                                                    <p><?php echo $row['email'] ?></p>
                                                    <p><?php echo $row['mobile'] ?></p>
                                                </td>
                                                <td>
                                                    <?php echo $row['address'] ?>
                                                    <p><?php echo $row['zip'] ?></p>
                                                </td>

                                                <td><?php echo $row['total_price'] ?> tk</td>

                                                <td>
                                                    <div class="payment_status_<?php echo $row['payment_status'] ?>">
                                                        <?php echo $row['payment_status'] ?>
                                                    </div>
                                                </td>
                                                <td><?php echo $row['payment_type'] ?></td>
                                                <td><?php echo $row['order_status_name'] ?><br>
                                                <a href="?set_delivered_id=<?php echo $row['id'] ?>" class="pt-2 "><b>Set Deliverded</b></a>
                                            </td>
                                                <td><?php echo $fm->dateFormat($row['added_on']) ?></td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo '<td colspan="8" class="not_found">Data not found!</td>';
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE-->
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include 'inc/footer.php' ?>