<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'inc/topbar.php' ?>
    <!-- HEADER DESKTOP-->

<?php 
    // Deactive 
    if ( isset($_GET['deactive_id']) && $_GET['deactive_id'] != "" ) {
        $deactive_id = $_GET['deactive_id'];
        $deactiveDeliveryBoy = $customer->deactiveDeliveryBoy($deactive_id);
        if ($deactiveDeliveryBoy) {
            echo '<script>window.location = "delivery_boy.php"; </script>';
        }
    }

    // Active 
    if ( isset($_GET['active_id']) && $_GET['active_id'] != "" ) {
        $active_id = $_GET['active_id'];
        $activeDeliveryBoy = $customer->activeDeliveryBoy($active_id);
        if ($activeDeliveryBoy) {
            echo '<script>window.location = "delivery_boy.php"; </script>';
        }
    }

    // Delete Category
    if ( isset($_GET['delete_id']) && $_GET['delete_id'] != "" ) {
        $delete_id = $_GET['delete_id'];
        $deleteDeliveryBoy = $customer->deleteDeliveryBoy($delete_id);
        if ($deleteDeliveryBoy) {
            echo '<script>window.location = "delivery_boy.php"; </script>';
        }
    }
 ?>
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Delivery Boy List</h2>
                            <!-- Button trigger modal -->
                            <button type="button" data-toggle="modal" data-target="#exampleModal" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-plus"></i>add delivery boy</button>
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
                                                <th>Serial No</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                $getDeliveryBoy = $customer->getDeliveryBoy();
                                                if ($getDeliveryBoy) { 
                                                    $i = 0;
                                                    while ($row = $getDeliveryBoy->fetch_assoc()) {
                                                        $i++;
                                                ?>

                                            <tr class="text-center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['mobile'] ?></td>
                                                <td><?php 
                                                 $totalSecond = strtotime($row['date']);
                                                echo date('d-m-Y', $totalSecond);
                                                ?></td>
                                                <td>
                                                <?php 
                                                    if ($row['status'] == 0 ) { ?>
                                                         <a href="?deactive_id=<?php echo $row["id"] ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure to Deactivate?')">Deactive<a>
                                                    <?php  }else{ ?>
                                                         <a href="?active_id=<?php echo $row["id"] ?>" class="btn btn-warning btn-sm px-3" onclick="return confirm('Are you sure to Activate?')">Active<a>
                                                 <?php } ?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="delivery_boy_edit.php?edit_id=<?php echo $row['id'] ?>" class="item bg-info" data-toggle="tooltip" data-placement="top" title="Edit" >
                                                            <i class="zmdi zmdi-edit text-white"></i>
                                                        </a> &nbsp;&nbsp;
                                                        <a href="?delete_id=<?php echo $row['id'] ?>" class="item bg-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure to Delete?')">
                                                            <i class="zmdi zmdi-delete text-white"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } } else{
                                            echo '<td colspan="6" class="not_found">Data not found!</td>';
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

                   <!-- Insert Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Add Delivery Boy</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="#" method="post">
                             <div class="form-group px-4">
                                    <label class="form-control-labe"><strong>Name</strong></label>
                                    <input type="text" class="form-control" placeholder="Name.." id="name">
                              </div>
                                <div class="form-group px-4">
                                    <label class=" form-control-labe"><strong>Mobile</strong></label>
                                    <input type="number" class="form-control" placeholder="Mobile.." id="mobile">
                                </div>
                                <div class="form-group px-4">
                                    <label class=" form-control-labe"><strong>Password</strong></label>
                                    <input type="password" class="form-control" placeholder="Password.." id="password">
                                </div>
                              </div>
                            </form>
                            <div class="modal-footer">
                                <span id="showMsg"></span>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" onclick="addDeliveryBoy()" class="btn btn-primary">Save</button>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>


<?php include 'inc/footer.php' ?>