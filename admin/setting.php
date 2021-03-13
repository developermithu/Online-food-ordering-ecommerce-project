<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<?php 
if (isset($_POST['update'])) {
$cart_min_price               = $fm->validation($_POST['cart_min_price']);
$cart_min_price_msg     = $fm->validation($_POST['cart_min_price_msg']);
$website_close               = $fm->validation($_POST['website_close']);
$website_close_msg     = $fm->validation($_POST['website_close_msg']);

$query = "UPDATE `tbl_setting` SET
     `cart_min_price`            = '$cart_min_price',
     `cart_min_price_msg`  = '$cart_min_price_msg',
     `website_close`             = '$website_close',
      `website_close_msg`  = '$website_close_msg'
       WHERE `id` = '1' ";
    $result = $db->update($query);
    if ($result == true) {
        header('location:index.php');
    } else {
        echo '<span class="text-danger"><b>Something went wrong!</b></span>';
        exit();
    }
}
?>

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
                            <h2 class="title-1">Setting</h2>
                            <!-- Button trigger modal -->
                            <a href="index.php" class="au-btn au-btn-icon au-btn--blue">Back</a>
                        </div>
                    </div>
                </div>

                <div class="row m-t-40">
                    <div class="col-md-8 offset-2">

                        <form action="" method="post" class="form-horizontal bg-light px-4 py-5">
                            <?php
                            $query = "SELECT * FROM `tbl_setting` WHERE `id` = '1' ";
                            $result = $db->select($query);
                            $website_close_arr = array('No', 'Yes');
                            if ($result) {
                                $row = $result->fetch_assoc();
                                ?>
                                
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Cart Min Price</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="number" name="cart_min_price" class="form-control" value="<?php echo $row['cart_min_price'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Cart Min Price Message</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" name="cart_min_price_msg" class="form-control" value="<?php echo $row['cart_min_price_msg'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Website Close</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select name="website_close" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <?php 
                                            foreach($website_close_arr as $key=>$val){
                                                if ($website_close == $key) {
                                                    echo "<option value='$key' selected>$val</option>"; 
                                                }else{
                                                    echo "<option value='$key' >$val</option>";
                                                }
                                            }
                                             ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-labe"><strong>Website Close Message</strong></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" name="website_close_msg" class="form-control" value="<?php echo $row['website_close_msg'] ?>" required>
                                        </div>
                                    </div>
 
                                    <button name="update" type="submit" class="btn btn-primary px-3 mt-2" style="margin-left: 170px;">Update</button>

                            <?php 
                            } ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'inc/footer.php' ?>