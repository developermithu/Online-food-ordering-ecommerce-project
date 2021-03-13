<?php
$page = 'home';
include 'inc/header.php';
include 'inc/header_bottom.php';
?>

<!-- Slider Area -->
<div class="slider-area">
    <div class="slider-active owl-dot-style owl-carousel">
        <?php
        $getAllSlider = $proccess->getAllSlider();
        if ($getAllSlider) {
            while ($row = $getAllSlider->fetch_assoc()) {   ?>
                <div class="single-slider pt-70 pb-180 bg-img" style="background-image:url(admin/<?php echo $row['image'] ?>)">
                    <div class="container">
                        <div class="slider-content slider-animated-1">
                            <h1 class="animated"><?php echo $row['title'] ?></h1>
                            <h3 class="animated"><?php echo $row['sub_title'] ?></h3>
                            <div class="slider-btn mt-90">
                                <a class="animated" href="<?php echo $row['link'] ?>"><?php echo $row['link_text'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>
<!-- Slider Area -->

<!-- Banner Area -->
<!-- <div class="banner-area row-col-decrease pt-100 pb-75 clearfix">
    <div class="container">
        <div class="banner-left-side mb-20">
            <div class="single-banner">
                <div class="hover-style">
                    <a href="#"><img src="assets/img/banner/banner-1.jpg" alt=""></a>
                </div>
            </div>
        </div>
        <div class="banner-right-side mb-20">
            <div class="single-banner mb-20">
                <div class="hover-style">
                    <a href="#"><img src="assets/img/banner/banner-2.jpg" alt=""></a>
                </div>
            </div>
            <div class="single-banner">
                <div class="hover-style">
                    <a href="#"><img src="assets/img/banner/banner-3.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Banner Area -->

<!-- Product Area -->
<div class="product-area pb-70 pt-80">
    <div class="custom-container">
        <div class="product-tab-list-wrap text-center mb-40">
            <div class="product-tab-list nav">
                <a class="active" href="#tab1" data-toggle="tab">
                    <h4>All </h4>
                </a>
                <a href="#tab2" data-toggle="tab">
                    <h4>Vegetables </h4>
                </a>
                <a href="#tab3" data-toggle="tab">
                    <h4> Non Vegetables </h4>
                </a>
            </div>
        </div>

        <div class="tab-content jump mt-3">

            <!-- All Tab Item -->
            <div id="tab1" class="tab-pane active">
                <div class="row">
                    <?php
                    $query = "SELECT * FROM `tbl_dish` WHERE `status` = 0 ORDER BY rand() LIMIT 8 ";
                    $result = $db->select($query);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-lg-3 col-md-4">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="<?php echo SITE_PATH ?>product_details?id=<?php echo $row['id'] ?>">
                                            <img src="admin/<?php echo $row['image'] ?>" alt="<?php echo $row['dish'] ?>">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <?php
                                                if ($website_close == 0) { ?>
                                                    <a href="javascript:void(0)" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')"><i class="fa fa-cart-plus"></i>Add To Cart</a>
                                                <?php  } else {
                                                    echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            $login = Session::get('userLogin');
                                            if ($login == true) { ?>
                                                <div class="pro-action-right">
                                                    <a href="<?php echo SITE_PATH ?>wishlist">
                                                        <i class="fas fa-heart"></i>Wishlist</a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="product_details?id=<?php echo $row['id'] ?>">
                                                <?php echo $row['dish'] ?>
                                            </a>
                                        </h4>

                                        <div class="product-price-wrapper">
                                            <?php
                                            $dish_id = $row['id'];
                                            $getDishAttribute = $dish->getDishAttribute($dish_id);
                                            if ($getDishAttribute) {
                                                while ($dish_details = $getDishAttribute->fetch_assoc()) {
                                                    if ($website_close == 0) {
                                            ?>
                                                        <input type="radio" name="attr<?php echo $row['id'] ?>" id="attr<?php echo $row['id'] ?>" value="<?php echo $dish_details['id'] ?>">

                                                    <?php }
                                                    echo $dish_details['attribute'] ?>
                                                    <span>(<?php echo $dish_details['price'] ?>&#2547;)</span>

                                                    <?php
                                                    $added_msg = "";
                                                    if (array_key_exists($dish_details['id'], $cartArr)) {
                                                        $added_qty = getUserCartFullDetails($dish_details['id']);
                                                        $added_msg = "(added - $added_qty)";
                                                        echo "<span class='added' id='shop_added_msg_" . $dish_details['id'] . "'>" . $added_msg . "</span>";
                                                    }
                                                    ?>
                                                    <!-- taka symbol &#2547; -->
                                            <?php }
                                            } ?>
                                        </div>

                                        <?php
                                        if ($website_close == 0) { ?>
                                            <div class="add-to-cart mt-3">
                                                <div class="qty">
                                                    <select id="qty<?php echo $row['id'] ?>" class=" form-control">
                                                        <option value="0">QTY</option>
                                                        <?php
                                                        for ($i = 1; $i <= 10; $i++) {
                                                            echo '<option>' . $i . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="add-to-cart-btn">
                                                    <a href="javascript:void(0)"><i class="fa fa-cart-plus fa-2x" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')"></i></a>
                                                </div>
                                            </div>
                                        <?php  } else {
                                            echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>

            <!-- Tab 2 Vegetables Item -->
            <div id="tab2" class="tab-pane">
                <div class="row">
                    <?php
                    $query = "SELECT * FROM `tbl_dish` WHERE `type` = 'veg' AND `status` = 0 ORDER BY rand() LIMIT 8 ";
                    $result = $db->select($query);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-lg-3 col-md-4">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="<?php echo SITE_PATH ?>product_details?id=<?php echo $row['id'] ?>">
                                            <img src="admin/<?php echo $row['image'] ?>" alt="dish-img">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <?php
                                                if ($website_close == 0) { ?>
                                                    <a href="javascript:void(0)" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')"><i class="fa fa-cart-plus"></i>Add To Cart</a>
                                                <?php  } else {
                                                    echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            $login = Session::get('userLogin');
                                            if ($login == true) { ?>
                                                <div class="pro-action-right">
                                                    <a href="<?php echo SITE_PATH ?>wishlist">
                                                        <i class="fas fa-heart"></i>Wishlist</a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="product_details?id=<?php echo $row['id'] ?>">
                                                <?php echo $row['dish'] ?>
                                            </a>
                                        </h4>

                                        <div class="product-price-wrapper">
                                            <?php
                                            $dish_id = $row['id'];
                                            $getDishAttribute = $dish->getDishAttribute($dish_id);
                                            if ($getDishAttribute) {
                                                while ($dish_details = $getDishAttribute->fetch_assoc()) {
                                                    if ($website_close == 0) {
                                            ?>
                                                        <input type="radio" name="attr<?php echo $row['id'] ?>" id="attr<?php echo $row['id'] ?>" value="<?php echo $dish_details['id'] ?>">

                                                    <?php }
                                                    echo $dish_details['attribute'] ?>
                                                    <span>(<?php echo $dish_details['price'] ?>&#2547;)</span>

                                                    <?php
                                                    $added_msg = "";
                                                    if (array_key_exists($dish_details['id'], $cartArr)) {
                                                        $added_qty = getUserCartFullDetails($dish_details['id']);
                                                        $added_msg = "(added - $added_qty)";
                                                        echo "<span class='added' id='shop_added_msg_" . $dish_details['id'] . "'>" . $added_msg . "</span>";
                                                    }
                                                    ?>
                                                    <!-- taka symbol &#2547; -->
                                            <?php }
                                            } ?>
                                        </div>

                                        <?php
                                        if ($website_close == 0) { ?>
                                            <div class="add-to-cart mt-3">
                                                <div class="qty">
                                                    <select id="qty<?php echo $row['id'] ?>" class=" form-control">
                                                        <option value="0">QTY</option>
                                                        <?php
                                                        for ($i = 1; $i <= 10; $i++) {
                                                            echo '<option>' . $i . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="add-to-cart-btn">
                                                    <a href="javascript:void(0)"><i class="fa fa-cart-plus fa-2x" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')"></i></a>
                                                </div>
                                            </div>
                                        <?php  } else {
                                            echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>

            <!-- Tab 3 Non Vegetables -->
            <div id="tab3" class="tab-pane">
            <div class="row">
                    <?php
                    $query = "SELECT * FROM `tbl_dish` WHERE `type` = 'non-veg' AND `status` = 0 ORDER BY rand() LIMIT 8 ";
                    $result = $db->select($query);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-lg-3 col-md-4">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="<?php echo SITE_PATH ?>product_details?id=<?php echo $row['id'] ?>">
                                            <img src="admin/<?php echo $row['image'] ?>" alt="<?php echo $row['dish'] ?>">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <?php
                                                if ($website_close == 0) { ?>
                                                    <a href="javascript:void(0)" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')"><i class="fa fa-cart-plus"></i>Add To Cart</a>
                                                <?php  } else {
                                                    echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            $login = Session::get('userLogin');
                                            if ($login == true) { ?>
                                                <div class="pro-action-right">
                                                    <a href="<?php echo SITE_PATH ?>wishlist">
                                                        <i class="fas fa-heart"></i>Wishlist</a>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="product_details?id=<?php echo $row['id'] ?>">
                                                <?php echo $row['dish'] ?>
                                            </a>
                                        </h4>

                                        <div class="product-price-wrapper">
                                            <?php
                                            $dish_id = $row['id'];
                                            $getDishAttribute = $dish->getDishAttribute($dish_id);
                                            if ($getDishAttribute) {
                                                while ($dish_details = $getDishAttribute->fetch_assoc()) {
                                                    if ($website_close == 0) {
                                            ?>
                                                        <input type="radio" name="attr<?php echo $row['id'] ?>" id="attr<?php echo $row['id'] ?>" value="<?php echo $dish_details['id'] ?>">

                                                    <?php }
                                                    echo $dish_details['attribute'] ?>
                                                    <span>(<?php echo $dish_details['price'] ?>&#2547;)</span>

                                                    <?php
                                                    $added_msg = "";
                                                    if (array_key_exists($dish_details['id'], $cartArr)) {
                                                        $added_qty = getUserCartFullDetails($dish_details['id']);
                                                        $added_msg = "(added - $added_qty)";
                                                        echo "<span class='added' id='shop_added_msg_" . $dish_details['id'] . "'>" . $added_msg . "</span>";
                                                    }
                                                    ?>
                                                    <!-- taka symbol &#2547; -->
                                            <?php }
                                            } ?>
                                        </div>

                                        <?php
                                        if ($website_close == 0) { ?>
                                            <div class="add-to-cart mt-3">
                                                <div class="qty">
                                                    <select id="qty<?php echo $row['id'] ?>" class=" form-control">
                                                        <option value="0">QTY</option>
                                                        <?php
                                                        for ($i = 1; $i <= 10; $i++) {
                                                            echo '<option>' . $i . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="add-to-cart-btn">
                                                    <a href="javascript:void(0)"><i class="fa fa-cart-plus fa-2x" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')"></i></a>
                                                </div>
                                            </div>
                                        <?php  } else {
                                            echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End-->

<!-- Banner Area -->
<div class="banner-area">
    <div class="discount-overlay bg-img pt-40 pb-40" style="background-image:url(assets/img/banner/banner-4.jpg);">
        <div class="discount-content text-center">
            <h3>It’s Time To Start <br>Your Own Revolution By Laurent</h3>
            <p>Exclusive Offer -10% Off This Week</p>
            <div class="banner-btn">
                <a href="<?php echo SITE_PATH ?>shop">Order Now</a>
            </div>
        </div>
    </div>
</div>
<!-- Banner Area -->

<!-- Best Food Area -->
<div class="best-food-area pt-80 pb-80">
    <div class="product-tab-list text-center pb-5">
        <a href="javascript:void(0)">
            <h4>Most Selling Food In Our Shop</h4>
        </a>
    </div>

    <div class="custom-container">
        <div class="row">
            <?php
            $query = "SELECT COUNT(`tbl_dish_details`.`dish_id`) AS `total`,  `tbl_dish_details`.`dish_id`, `tbl_dish`.* FROM `tbl_dish_details`, `tbl_dish` WHERE `tbl_dish`.`id` = `tbl_dish_details`.`dish_id` GROUP BY `tbl_dish_details`.`dish_id` ORDER BY COUNT(`tbl_dish_details`.`dish_id`) DESC LIMIT 4  ";
            $result = $db->select($query);
            if ($result) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-lg-3 col-md-4">
                        <div class="product-wrapper mb-25">
                            <div class="product-img">
                                <a href="<?php echo SITE_PATH ?>product_details?id=<?php echo $row['id'] ?>">
                                    <img src="admin/<?php echo $row['image'] ?>" alt="<?php echo $row['dish'] ?>">
                                </a>
                            </div>
                            <div class="product-content">
                                <h4>
                                    <a href="product_details?id=<?php echo $row['id'] ?>">
                                        <?php echo $row['dish'] ?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>
<!-- Best Food  Area -->


<div class="brand-logo-area pt-20 pb-80">
    <div class="container">
        <div class="brand-logo-active owl-carousel">
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-1.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-2.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-3.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-4.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-5.png">
            </div>
            <div class="single-brand-logo">
                <img alt="" src="assets/img/brand-logo/logo-2.png">
            </div>
        </div>
    </div>
</div>



<?php include 'inc/footer.php' ?>