<?php 
    // Get Category
    if ( isset($_GET['edit_id']) && $_GET['edit_id'] != "") {
        $edit_id = $_GET['edit_id'];
    }else{
        echo '<script>window.location = "coupon_code.php"; </script>';
    }
?>

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
                            <h2 class="title-1">Update Coupon Code</h2>
                            <!-- Button trigger modal -->
                            <a href="coupon_code.php" class="au-btn au-btn-icon au-btn--blue">Back</a>
                        </div>
                    </div>
                </div>

                   <div class="row m-t-40">
                            <div class="col-md-8 offset-2">
                                <form action="#" method="post" class="form-horizontal bg-light px-4 py-5">
                        <?php 
                                $getCategory = $category->getCategory($edit_id);
                                if ($getCategory) {
                                    while ($row = $getCategory->fetch_assoc()) { ?>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Category Name</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="updateCatname" class="form-control" value="<?php echo $row['catName']?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Order Number</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="number" id="updateOrdernumber" class="form-control" value="<?php echo $row['order_number']?>">
                                        </div>
                                    </div>
                                    <input type="hidden" id="hidden_id" value="<?php echo $row['id']?>">
                                    <button type="button" class="btn btn-primary px-3 mt-2" style="margin-left: 170px;" onclick="updateCategory()">Update</button>
                                    <input type="reset" value="Reset" class="btn btn-warning px-3 mt-2 ml-1">

                                    <span id="showMsg" class="ml-3"></span>

                                <?php } } ?>
                                                                    
                                </form>
                            </div>
                        </div>
					</div>
			</div>
	</div>


<?php include 'inc/footer.php' ?>