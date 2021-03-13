<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<?php
if (isset($_POST['submit'])) {
     $addDish = $dish->addDish($_POST);
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

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Category *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <select name="category" class=" form-control" required>
                                        <option value="">Select category</option>
                                        <?php
                                        $getCategoryList = $category->getCategoryList();
                                        if ($getCategoryList) {
                                            while ($row = $getCategoryList->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['id'] ?>">
                                                    <?php echo $row['catName'] ?></option>
                                        <?php }
                                        }  ?>
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
                                        <option value="veg">Veg</option>
                                        <option value="non-veg">Non-Veg</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Dish Name *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="dish" class="form-control" placeholder="Dish name.." required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Dish Description *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <textarea name="dish_details" id="editor" class="form-control" placeholder="Dish details.."></textarea> <!-- ckeditor thakle required not work -->
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Dish Image *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="file" name="image" class="form-control" required>
                                    <small class="text-danger">Allowed only: jpg, png, jpeg (less than 1mb).</small>
                                </div>
                            </div>

                            <!-- Add More -->
                            <div id="attribute_box">
                                <div class="row form-group mt-3">
                                    <div class="col col-md-2">
                                        <label class=" form-control-labe"><strong>Dish Details *</strong></label>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="text" name="attribute[]" placeholder="Attribute.." class="form-control" required>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <input type="number" name="price[]" placeholder="Price.." class="form-control" required>
                                    </div>
                                    <div class="col-12 col-md-3">
                                       <select name="status[]" class="form-control" required>
                                           <option value="">Select Status</option>
                                           <option value="0">Active</option>
                                           <option value="1">Deactive</option>
                                       </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary px-4 mt-2" style="margin-left: 170px;">Submit</button>

                            <button type="button" class="btn btn-warning px-3 mt-2 ml-2" onclick="add_more_btn()">Add More</button>
                            
                            <?php
                            if (isset($addDish)) {
                                echo $addDish;
                            }
                            ?>
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
    </script>


    <?php include 'inc/footer.php' ?>