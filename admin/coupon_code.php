<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'inc/topbar.php' ?>
    <!-- HEADER DESKTOP-->

<?php 
    // Deactive Category
    if ( isset($_GET['deactive_id']) && $_GET['deactive_id'] != "" ) {
        $deactive_id = $_GET['deactive_id'];
        $deactive = $proccess->deactive($deactive_id);
        if ($deactive) {
            echo '<script>window.location = "coupon_code.php"; </script>';
        }
    }

    // Active Category
    if ( isset($_GET['active_id']) && $_GET['active_id'] != "" ) {
        $active_id = $_GET['active_id'];
        $active = $proccess->active($active_id);
        if ($active) {
            echo '<script>window.location = "coupon_code.php"; </script>';
        }
    }

    // Delete Category
    if ( isset($_GET['delete_id']) && $_GET['delete_id'] != "" ) {
        $delete_id = $_GET['delete_id'];
        $deleteCouponCode = $proccess->deleteCouponCode($delete_id);
        if ($deleteCouponCode) {
            echo '<script>window.location = "coupon_code.php"; </script>';
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
                            <h2 class="title-1">Coupon List</h2>
                            <!-- Button trigger modal -->
                            <button type="button" data-toggle="modal" data-target="#exampleModal" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-plus"></i>add coupon</button>
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
                                                <th>No</th>
                                                <th>Code</th>
                                                <th>Value</th>
                                                <th>Type</th>
                                                <th>Min Value</th>
                                                <th>Expired</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                $getCouponCode = $proccess->getCouponCode();
                                                if ($getCouponCode) { 
                                                    $i = 0;
                                                    while ($row = $getCouponCode->fetch_assoc()) {
                                                        $i++;
                                                ?>

                                            <tr class="text-center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['coupon_code'] ?></td>
                                                <td><?php echo $row['coupon_value'] ?></td>
                                                <td><?php echo $row['coupon_type'] ?></td>
                                                <td><?php echo $row['cart_min_value'] ?></td>
                                                <td><?php echo $row['expired_on'] ?></td>
                                                <td>
                                                <?php 
                                                    if ($row['status'] == 0 ) { ?>
                                                         <a href="?deactive_id=<?php echo $row["id"] ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure to Deactivate this category?')">Deactive<a>
                                                    <?php  }else{ ?>
                                                         <a href="?active_id=<?php echo $row["id"] ?>" class="btn btn-warning btn-sm px-3" onclick="return confirm('Are you sure to Activate this category?')">Active<a> 
                                                 <?php } ?>
                                                    </td>  
                                                    <td>
                                                        <div class="table-data-feature">
                                                        <a href="?edit_id=<?php echo $row['id'] ?>" class="item bg-info" data-toggle="tooltip" data-placement="top" title="Edit" >
                                                            <i class="zmdi zmdi-edit text-white"></i>
                                                        </a> &nbsp;
                                                        <a href="?delete_id=<?php echo $row['id'] ?>" class="item bg-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure to Delete?')">
                                                            <i class="zmdi zmdi-delete text-white"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } } else{
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

                   <!-- Insert Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Add New Coupon</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                                <form action="#" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Code</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="coupon_code" class="form-control" placeholder="Coupon code..">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Value</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="number" id="coupon_value" class="form-control" placeholder="Coupon value..">
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Type</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select id="coupon_type" class="form-control">
                                                <option value="">Select type</option>
                                                <option value="Percentage">Percentage</option>
                                                <option value="Fixed">Fixed</option>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Min Value</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="number" id="cart_min_value" class="form-control" placeholder="Cart min value..">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Expired On</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="date" id="expired_on" class="form-control" placeholder="Expired date..">
                                        </div>
                                    </div>                                        
                                </form>
                                <div class="modal-footer">
                                <span id="showMsg"></span>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="addCoupon()" class="btn btn-primary">Save</button>
                                  </div>
                          </div>
                        </div>
                      </div>
                    </div>


<?php include 'inc/footer.php' ?>