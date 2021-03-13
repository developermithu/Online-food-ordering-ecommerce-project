<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<?php
if (isset($_GET['edit_id']) && $_GET['edit_id'] != "") {
    $edit_id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['edit_id']);

    if (isset($_POST['submit'])) {
        $updateDish = $dish->updateDish($_POST, $_FILES, $edit_id);
    }
} else {
    echo '<script>window.location = "dish.php"; </script>';
}

if (isset($_GET['dish_details_id']) && $_GET['dish_details_id'] > 0) {
    $dish_details_id =  preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['dish_details_id']);
    $query = "DELETE FROM `tbl_dish_details` WHERE `id` = '$dish_details_id' ";
    $db->delete($query);
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
                            <h2 class="title-1">Dish List</h2>
                            <!-- Button trigger modal -->
                            <a href="dish.php" class="au-btn au-btn-icon au-btn--blue">Back</a>
                        </div>
                    </div>
                </div>

                <div class="row m-t-40">
                    <div class="col-md-12">
                        <form action="" method="post" class="form-horizontal bg-light px-4 py-5" enctype="multipart/form-data">

                            <?php
                            $getDish = $dish->getDishDetailsById($edit_id);
                            if ($getDish) {
                                while ($row = $getDish->fetch_assoc()) {
                                    $type = $row['type'];
                            ?>

                                    <div class="row form-group">
                                        <div class="col col-md-2">
                                            <label class=" form-control-labe"><strong>Dish Image *</strong></label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <input type="file" name="image" class="form-control">
                                            <small class="text-danger">Allowed only: jpg, png, jpeg (less than 1mb).</small>
                                        </div>
                                        <div class="col-12 col-md-4 ml-auto">
                                            <a target="blank" href="<?php echo $row['image'] ?>">
                                                <img src="<?php echo $row['image'] ?>" width="35%" style="margin-top: -25px;border-radius:50px">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-2">
                                            <label class=" form-control-labe"><strong>Category *</strong></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <select name="category" class=" form-control" required>
                                                <option value="">Select category</option>

                                                <?php
                                                $getCategory = $dish->getCategoryData();
                                                if ($getCategory) {
                                                    while ($category = $getCategory->fetch_assoc()) {

                                                ?>

                                                        <option value="<?php echo $category['id'] ?>" <?php
                                                                                                        if ($category['id'] == $row['category_id']) {
                                                                                                            echo 'selected';
                                                                                                        } ?>>
                                                            <?php echo $category['catName'] ?>
                                                                
                                                            </option>

                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-2">
                                            <label class=" form-control-labe"><strong>Type *</strong></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <select name="type" class=" form-control" required>
                                                <option value="">Select type</option>
                                                <?php
                                                if ($type == "veg") {
                                                    echo '<option value="veg" selected>Veg</option> <option value="non-veg">Non-Veg</option>';
                                                } else if ($type == "non-veg") {
                                                    echo '<option value="veg">Veg</option>
                                             <option value="non-veg" selected>Non-Veg</option>';
                                                } else {
                                                    echo '<option value="veg">Veg</option>
                                            <option value="non-veg">Non-Veg</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-2">
                                            <label class=" form-control-labe"><strong>Dish *</strong></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <input type="text" name="dish" class="form-control" value="<?php echo $row['dish'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-2">
                                            <label class=" form-control-labe"><strong>Dish Details *</strong></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <textarea name="dish_details" id="editor" class="form-control">
                                         <?php echo $row['dish_details'] ?> 
                                        </textarea>
                                        </div>
                                    </div>

                                    <!-- Add More -->
                                    <div id="attribute_box">
                                        <?php
                                        $query = "SELECT * FROM `tbl_dish_details` WHERE `dish_id` = '$edit_id' ";
                                        $result = $db->select($query);
                                        if ($result) {
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) { ?>

                                                <div class="row form-group mt-3">
                                                    <div class="col col-md-2">
                                                        <label class=" form-control-labe"><strong>Dish Details *</strong></label>
                                                    </div>
                                                    <input type="hidden" name="dish_details_id[]" value="<?php echo $row['id'] ?>">
                                                    <div class="col-12 col-md-3">
                                                        <input type="text" name="attribute[]" value="<?php echo $row['attribute'] ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <input type="number" name="price[]" value="<?php echo $row['price'] ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <select name="status[]" class="form-control" required>
                                                            <option value="">Select Status</option>
                                                            <?php 
                                                                if ($row['status'] == '0' ) { ?>
                                                                    <option value="0" selected>Active</option>
                                                                    <option value="1">Deactive</option>
                                                                <?php }
                                                                 if($row['status'] == '1' ) { ?>
                                                                    <option value="1" selected>Deactive</option>
                                                                    <option value="0">Active</option>
                                                               <?php } ?>
                                                        </select>
                                                    </div>
                                                    <?php
                                                    if ($i != 1) { ?>
                                                        <div class="col-12 col-md-2"><button type="button" class="btn btn-danger px-4" onclick="remove_details(<?php echo $row['id'] ?>)">Remove</button></div>
                                                    <?php  } ?>
                                                </div>
                                        <?php $i++;
                                            }
                                        } ?>
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary px-4 mt-3" style="margin-left: 170px;">Update</button> &nbsp;

                                    <button type="button" class="btn btn-warning px-3 mt-3 " onclick="add_more_btn()">Add More</button>

                                    <?php
                                    if (isset($updateDish)) {
                                        echo $updateDish;
                                    }
                                    ?>

                            <?php }
                            } ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="add_more" value="1">
    <script>
        function add_more_btn() {
            var add_more = $('#add_more').val();
            add_more++;
            $('#add_more').val(add_more);
            var html = '<div class="row mt-3 col-md-12" id="box' + add_more + '"><div class="col-12 col-md-2"></div><div class="col-12 col-md-3"><input type="text" name="attribute[]" placeholder="Attribute.. "class="form-control" required></div><div class="col-12 col-md-2"><input type="number" name="price[]" placeholder="Price.." class="form-control" required></div><div class="col-12 col-md-3"><select name="status[]" class="form-control" required><option value="">Select Status</option><option value="0">Active</option><option value="1">Deactive</option></select></div><div class="col-12 col-md-2"><button type="button" class="btn btn-danger px-4" onclick=remove_btn("' + add_more + '")>Remove</button></div></div>';

            $('#attribute_box').append(html);
        }

        function remove_btn(id) {
            $('#box' + id).remove();
        }

        function remove_details(id) {
            var result = confirm('Are you sure?');
            if (result == true) {
                var cur_path = window.location.href;
                window.location.href = cur_path + "&dish_details_id=" + id;
            }

        }
    </script>

    <?php include 'inc/footer.php' ?>