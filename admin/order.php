<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'inc/topbar.php' ?>
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
                                    $orderDetails = $customer->getOrderDetails();
                                    if ($orderDetails) {
                                        while ($row = $orderDetails->fetch_assoc()) {
                                    ?>

                                            <tr class="text-center">
                                                <td><a class="btn-info w-100 py-1" href="order_details.php?oid=<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a></td>
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
                                                <td><?php echo $row['order_status_name'] ?></td>
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