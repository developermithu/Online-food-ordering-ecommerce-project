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
                            <h2 class="title-1">overview</h2>
                            <!-- <button class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-plus"></i>add item</button> -->
                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2>
                                            <?php
                                            $start = date('Y-m-d') . ' 00-00-00'; //0 hour
                                            $end = date('Y-m-d') . ' 23-59-59'; //24 hour
                                            echo getSale($start, $end) . ' tk';
                                            ?>
                                        </h2>
                                        <span>Today's Sale</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-note"></i>
                                    </div>
                                    <div class="text">
                                        <h2>
                                            <?php
                                            $start = strtotime(date('Y-m-d'));
                                            $start = strtotime("-7 day", $start);
                                            $start = date('Y-m-d', $start);
                                            $end = date('Y-m-d') . ' 23-59-59';
                                            echo getSale($start, $end) . ' tk';
                                            ?>
                                        </h2>
                                        <span>Last 7 Day's Sale</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                    <div class="text">
                                        <h2>
                                            <?php
                                            $start = strtotime(date('Y-m-d'));
                                            $start = strtotime("-30 day", $start);
                                            $start = date('Y-m-d', $start);
                                            $end = date('Y-m-d') . ' 23-59-59';
                                            echo getSale($start, $end) . ' tk';
                                            ?>
                                        </h2>
                                        <span>Last 30 Day's Sale</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-account-o"></i>
                                    </div>
                                    <div class="text">
                                        <h2>
                                            <?php
                                            $start = strtotime(date('Y-m-d'));
                                            $start = strtotime("-365 day", $start);
                                            $start = date('Y-m-d', $start);
                                            $end = date('Y-m-d') . ' 23-59-59';
                                            echo getSale($start, $end) . ' tk';
                                            ?>
                                        </h2>
                                        <span>Last Year Sale</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2>
                                            <?php
                                            $query = "SELECT COUNT(`tbl_dish_details`.`dish_id`) AS `total`,  `tbl_dish_details`.`dish_id`, `tbl_dish`.`dish` FROM `tbl_dish_details`, `tbl_dish` WHERE `tbl_dish`.`id` = `tbl_dish_details`.`dish_id` GROUP BY `tbl_dish_details`.`dish_id` ORDER BY COUNT(`tbl_dish_details`.`dish_id`) DESC LIMIT 1  ";
                                            $result = $db->select($query);
                                            if ($result) {
                                                $row = $result->fetch_assoc();
                                                $t = $row['total'];
                                                echo $row['dish']. "($t)"; 
                                              
                                            }
                                            ?>
                                        </h2>
                                        <span>Most Saled Dish</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <h2>
                                            <?php
                                            $query = "SELECT COUNT(`tbl_order`.`user_id`) AS `total`,  `tbl_customer`.`name` FROM `tbl_order`, `tbl_customer` WHERE `tbl_order`.`user_id` = `tbl_customer`.`id` GROUP BY `tbl_order`.`user_id` ORDER BY COUNT(`tbl_order`.`user_id`) DESC LIMIT 1  ";
                                            $result = $db->select($query);
                                            if ($result) {
                                                $row = $result->fetch_assoc();
                                                $t = $row['total'];
                                                echo $row['name']."($t)"; 
                                            }
                                            ?>
                                        </h2>
                                        <span>Most Active Buyer</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest 5 order -->
                <div class="row m-t-30">
                    <div class="col-md-12">
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                            <table class="table table-data3">
                                <thead>
                                    <tr>
                                        <td colspan="8" class="text-left text-warning">Latest 5 Order</td>
                                    </tr>
                                    <tr>
                                        <th>Order <br> Id</th>
                                        <th style="vertical-align: middle;">Name / Email / Mobile</th>
                                        <th>Address <br> Zip</th>
                                        <th>Price</th>
                                        <th>Payment <br> Status</th>
                                        <th>Payment <br> Type</th>
                                        <th>Order <br>                                  Status</th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT `tbl_order`.*, `order_status`.`status` AS `order_status_name` FROM `tbl_order`, `order_status` WHERE `tbl_order`.`order_status` = `order_status`.`id` ORDER BY `tbl_order`.`id` DESC LIMIT 5";
                                    $result = $db->select($query);
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>

                                            <tr class="text-center">
                                                <td><a class="btn-info w-100 py-1 px-3" href="order_details.php?oid=<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a></td>
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


                <!-- Footer Area -->
                <?php include 'inc/footer.php'; ?>