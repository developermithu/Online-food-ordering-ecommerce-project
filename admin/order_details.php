<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'inc/topbar.php' ?>
    <!-- HEADER DESKTOP-->

    <?php
    if (isset($_GET['oid']) && $_GET['oid'] > 0) {
        $id = $_GET['oid'];

        if (isset($_GET['order_status'])) {
            $order_status = $_GET['order_status'];
            $cancel_at = date('y-m-d h:i:s');
            if ($order_status == 5) { //cancel hoy
                $query = "UPDATE `tbl_order` SET `order_status` = '$order_status', `cancel_by` = 'admin', `cancel_at` = '$cancel_at' WHERE `id` = '$id' ";
            } else {
                $query = "UPDATE `tbl_order` SET `order_status` = '$order_status' WHERE `id` = '$id' ";
            }
            $result = $db->update($query);
            redirect(SITE_PATH_ADMIN . 'order_details.php?oid=' . $id);
        }

        if (isset($_GET['delivery_boy'])) {
            $delivery_boy = $_GET['delivery_boy'];
            $query = "UPDATE `tbl_order` SET `delivery_boy_id` = '$delivery_boy' WHERE `id` = '$id' ";
            $result = $db->update($query);
            redirect(SITE_PATH_ADMIN . 'order_details.php?oid=' . $id);
        }

        $query = "SELECT `tbl_order`.*, `order_status`.`status` AS `order_status_name` FROM `tbl_order`, `order_status` WHERE `tbl_order`.`order_status` = `order_status`.`id` AND `tbl_order`.`id` = '$id' ORDER BY `tbl_order`.`id` DESC ";
        $result = $db->select($query);
        if ($result) {
            $orderRow = $result->fetch_assoc();
            $total_price = $orderRow['total_price'];
        } else {
            echo '<script>window.location = "index.php"; </script>';
        }
    } else {
        echo '<script>window.location = "index.php"; </script>';
    }
    ?>

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Order Details</h2>
                            <a href="order.php" class="au-btn au-btn-icon au-btn--blue">
                                </i>Back</a>
                        </div>
                    </div>
                </div>

                <div class="row m-t-30 bg-white">
                    <div class="col-md-12">
                        <h2 class="text-center pt-3">Order Id: <?php echo $id; ?></h2>
                        <div class="d-flex justify-content-between px-3 mt-5">
                            <div class="address">
                                <h4>Shop Name</h4>
                                Shop Address
                            </div>
                            <div class="invoice">
                                <h4>Invoice to</h4>
                                <?php echo $orderRow['name'] ?> <br>
                                <?php echo $orderRow['address'] ?> <br>
                                <?php echo $orderRow['zip'] ?> <br>

                            </div>
                        </div>
                        <div class="mt-5">
                            <h4>Order Date : <?php echo $fm->formatDate($orderRow['added_on']) ?></h4>
                        </div>
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40 mt-4">


                            <table class="table table-data3 text-center" id="myTable ">
                                <tr>
                                    <th>No.</th>
                                    <th>Dish</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                                <?php
                                $getOrderDetails = getOrderDetails($id); //function
                                $i = 1;
                                foreach ($getOrderDetails as $list) {
                                ?>
                                    <tr>
                                        <td> <?php echo $i; ?> </td>
                                        <td><?php echo $list['dish'] ?> (<?php echo $list['attribute'] ?>) </td>
                                        <td><?php echo $list['qty'] ?></td>
                                        <td class="mr-5"><?php echo $list['price'] ?>tk</td>
                                    </tr>
                                <?php $i++;
                                } ?>
                            </table>
                            <div class="pt-3 pr-3 text-right">
                                <h3>Total : <?php echo $total_price ?> </h3>
                            </div>

                            <div class="text-right mr-5 mt-2"><b>Order Status:</b> <?php echo $orderRow['order_status_name'] ?></div>
                            <div class="d-flex justify-content-between px-3 py-1">
                                <div>
                                    <a href="../download_invoice.php?id=<?php echo $id ?>" class="btn btn-info mt-2">Download PDF</a>
                                </div>

                                <div class="w-25">
                                    <select name="status" class="form-control" id="order_status" onchange="update_order_status('<?php echo $id ?>')">
                                        <option value="">Select Order Status</option>
                                        <?php
                                        $query = "SELECT * FROM `order_status` ORDER BY `id` ";
                                        $result = $db->select($query);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=" . $row['id'] . ">" . $row['status'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Delivery Boy Assign-->
                            <div class="d-flex justify-content-between px-3 py-2">
                                <div class=""><b>Delivery Boy :</b> <?php echo getDeliveryBoyNameById($orderRow['delivery_boy_id']) ?></div>

                                <div class="w-25">
                                    <select name="status" class="form-control" id="delivery_boy" onchange="update_delivery_boy('<?php echo $id ?>')">
                                        <option value="">Select Order Status</option>
                                        <?php
                                        $query = "SELECT * FROM `delivery_boy` WHERE `status` = '0' ORDER BY `name` ";
                                        $result = $db->select($query);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- END DATA TABLE-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function update_order_status(id) {
            var order_status = $('#order_status').val();
            if (order_status != "") {
                window.location.href = '<?php SITE_PATH_ADMIN ?>order_details.php?oid=' + id + '&order_status=' + order_status;
            }
        }

        function update_delivery_boy(id) {
            var delivery_boy = $('#delivery_boy').val();
            if (delivery_boy != "") {
                window.location.href = '<?php SITE_PATH_ADMIN ?>order_details.php?oid=' + id + '&delivery_boy=' + delivery_boy;
            }
        }
    </script>

    <?php include 'inc/footer.php' ?>