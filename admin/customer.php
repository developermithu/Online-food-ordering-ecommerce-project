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
                            <h2 class="title-1">Customer List</h2>
                        </div>
                    </div>
                </div>

                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-data3" id="myTable">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Serial No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>                      
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                $getCustomer = $customer->getCustomer();
                                                if ($getCustomer) { 
                                                    $i = 0;
                                                    while ($row = $getCustomer->fetch_assoc()) {
                                                        $i++;
                                                ?>

                                            <tr class="text-center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td><?php echo $row['mobile'] ?></td>
                                                <td><?php 
                                                 $totalSecond = strtotime($row['date']);
                                                echo $fm->formatDate2($row['date']);
                                                ?></td>
                                              
                                            </tr>
                                        <?php } } else{
                                            echo '<td colspan="7" class="not_found">Data not found!</td>';
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