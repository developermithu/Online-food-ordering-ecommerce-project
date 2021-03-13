<?php
include 'inc/header.php';
include 'inc/header_bottom.php';
?>

<?php
if (isset($_GET['id']) && $_GET['id'] != "") {
    $pid = $fm->validation($_GET['id']);
} else {
    echo '<script>window.location = "index"; </script>';
}
?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active">Product Details </li>
            </ul>
        </div>
    </div>
</div>

<div class="product-details pt-100 pb-90">
    <div class="container">
        <div class="row">

            <?php
            // $query = "SELECT * FROM `tbl_dish` WHERE `id` = '$pid' AND `status` = '0' ";

            $query = "SELECT `tbl_dish`.*, `tbl_dish_details`.`attribute`, `tbl_dish_details`.`price` FROM `tbl_dish`, `tbl_dish_details` WHERE  `tbl_dish_details`.`dish_id` = `tbl_dish`.`id` AND `tbl_dish`.`id` = '$pid' AND `tbl_dish`.`status` = '0' AND `tbl_dish_details`.`status` = '0' ";

            $result = $db->select($query);
            if ($result) {
                $row = $result->fetch_assoc() ?>

                <!-- image section -->
                <div class="col-lg-5 col-md-12">
                    <div class="product-details-img">
                        <img class="zoompro" src="admin/<?php echo $row['image'] ?>" data-zoom-image="admin/<?php echo $row['image'] ?>" alt="zoom" />
                        <div id="gallery" class="mt-20 product-dec-slider owl-carousel">
                            <a data-image="admin/<?php echo $row['image'] ?>" data-zoom-image="admin/<?php echo $row['image'] ?>">
                                <img src="assets/img/product-details/product-detalis-bl12.jpg" alt="">
                            </a>
                            <!-- <a data-image="assets/img/product-details/product-detalis-bl2.jpg" data-zoom-image="assets/img/product-details/product-detalis-bl2.jpg">
                                    <img src="assets/img/product-details/product-detalis-bl2.jpg" alt="">
                                </a>
                                <a data-image="assets/img/product-details/product-detalis-l3.jpg" data-zoom-image="assets/img/product-details/product-detalis-bl3.jpg">
                                    <img src="assets/img/product-details/product-detalis-s3.jpg" alt="">
                                </a>
                                <a data-image="assets/img/product-details/product-detalis-l4.jpg" data-zoom-image="assets/img/product-details/product-detalis-bl4.jpg">
                                    <img src="assets/img/product-details/product-detalis-s4.jpg" alt="">
                                </a>
                                <a data-image="assets/img/product-details/product-detalis-l5.jpg" data-zoom-image="assets/img/product-details/product-detalis-bl5.jpg">
                                    <img src="assets/img/product-details/product-detalis-s5.jpg" alt="">
                                </a>
                                <a data-image="assets/img/product-details/product-detalis-bl2.jpg" data-zoom-image="assets/img/product-details/product-detalis-bl2.jpg">
                                    <img src="assets/img/product-details/product-detalis-s2.jpg" alt="">
                                </a> -->
                        </div>
                        <span>-29%</span>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12">
                    <div class="product-details-content ml-5">
                        <h4><?php echo $row['dish'] ?></h4>
                        <div class="rating-review">
                            <div class="pro-dec-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="pro-dec-review">
                                <ul>
                                    <li>32 Reviews </li>
                                    <li> Add Your Reviews</li>
                                </ul>
                            </div>
                        </div>

                        <span>Price: <?php echo $row['price'] ?> tk</span>

                        <div class="product-price-wrapper mt-3">
                            <strong class="mr-3">Attribute:</strong>
                            <?php
                            $dish_id = $pid;
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

                        <div class="add-to-cart-box mt-3">
                            <?php
                            if ($website_close == 0) { ?>
                                <div class="mt-3">
                                    <div class="d-flex">
                                        <h5 class="mt-1"><b>Select Quantity:</b></h5>
                                        <select id="qty<?php echo $row['id'] ?>" class="w-50 ml-3 form-control">
                                            <?php
                                            for ($i = 1; $i <= 10; $i++) {
                                                echo '<option>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="product-wishlist-cart mt-4">
                                        <a href="javascript:void(0)" class="px-5" onclick="add_to_cart('<?php echo $row['id'] ?>', 'add')">
                                            Add To Cart
                                        </a>
                                    </div>
                                </div>
                            <?php  } else {
                                echo "<div class='add-to-cart mt-2 text-danger text-capitalize'>
                                                    <b>$website_close_msg</b>
                                                    </div>";
                            }
                            ?>
                        </div>
                        <div class="in-stock">
                            <p><b>Available:</b> <span>In stock</span></p>
                        </div>

                        <div class="pro-dec-categories">
                            <ul>
                                <li class="categories-title"><b>Categories:</b></li>
                                <li><a href="#">Fast Foods,</a></li>
                                <li><a href="#"> Rich Foods, </a></li>
                                <li><a href="#">Custom Orders,</a></li>
                                <li><a href="#">Home Decor,</a></li>
                                <li><a href="#">Weddings, </a></li>
                            </ul>
                        </div>
                        <div class="pro-dec-categories">
                            <ul>
                                <li class="categories-title"><b>Tags:</b> </li>
                                <li><a href="#"> Cheesy,</a></li>
                                <li><a href="#"> Fast Food, </a></li>
                                <li><a href="#"> French Fries,</a></li>
                                <li><a href="#"> Hamburger,</a></li>
                                <li><a href="#"> Pizza </a></li>
                            </ul>
                        </div>
                        <div class="pro-dec-social">
                            <ul>
                                <li><a class="tweet" href="#"><i class="fab fa-twitter"></i> Tweet</a></li>
                                <li><a class="share" href="#"><i class="fab fa-facebook"></i> Share</a></li>
                                <li><a class="google" href="#"><i class="fab fa-google"></i></i> Google+</a></li>
                                <li><a class="pinterest" href="#"><i class="fab fa-pinterest"></i></i> Pinterest</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div><!-- row end -->
    </div>
</div>
<div class="description-review-area pb-100">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav text-center">
                <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                <a data-toggle="tab" href="#des-details2">Tags</a>
                <!-- <a data-toggle="tab" href="#des-details3">Review</a> -->
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <?php echo $row['dish_details'] ?>
                    </div>
                </div>
                <div id="des-details2" class="tab-pane">
                    <div class="product-anotherinfo-wrapper">
                        <ul>
                            <li><span>Tags:</span></li>
                            <li><a href="#"> All,</a></li>
                            <li><a href="#"> Cheesy,</a></li>
                            <li><a href="#"> Fast Food,</a></li>
                            <li><a href="#"> French Fries,</a></li>
                            <li><a href="#"> Hamburger,</a></li>
                            <li><a href="#"> Pizza</a></li>
                        </ul>
                    </div>
                </div>
                <div id="des-details3" class="tab-pane">
                    <div class="rattings-wrapper">
                        <div class="sin-rattings">
                            <div class="star-author-all">
                                <div class="ratting-star f-left">
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <span>(5)</span>
                                </div>
                                <div class="ratting-author f-right">
                                    <h3>tayeb rayed</h3>
                                    <span>12:24</span>
                                    <span>9 March 2018</span>
                                </div>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                        </div>
                        <div class="sin-rattings">
                            <div class="star-author-all">
                                <div class="ratting-star f-left">
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <i class="ion-star theme-color"></i>
                                    <span>(5)</span>
                                </div>
                                <div class="ratting-author f-right">
                                    <h3>farhana shuvo</h3>
                                    <span>12:24</span>
                                    <span>9 March 2018</span>
                                </div>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                        </div>
                    </div>
                    <div class="ratting-form-wrapper">
                        <h3>Add your Comments :</h3>
                        <div class="ratting-form">
                            <form action="#">
                                <div class="star-box">
                                    <h2>Rating:</h2>
                                    <div class="ratting-star">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input placeholder="Name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input placeholder="Email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="rating-form-style form-submit">
                                            <textarea name="message" placeholder="Message"></textarea>
                                            <input type="submit" value="add review">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Related Products -->
<div class="product-area pb-95">
    <div class="container">
        <div class="product-top-bar section-border mb-25">
            <div class="section-title-wrap">
                <h3 class="section-title section-bg-white">Related Products</h3>
            </div>
        </div>
        <div class="related-product-active owl-carousel product-nav">

            <!-- Single Product -->
            <?php
                $catid = $row['category_id'];  //from prev while loop
                $query = "SELECT * FROM `tbl_dish` WHERE `category_id` = '$catid' AND `id` != '$pid' ";
                $result = $db->select($query);
                if ($result) {
                    while ($row2 = $result->fetch_assoc()) { ?>

                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="<?php echo SITE_PATH ?>product_details?id=<?php echo $row2['id'] ?>">
                                <img src="admin/<?php echo $row2['image'] ?>" alt="">
                            </a>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.html"><?php echo $row2['dish'] ?></a>
                            </h4>
                        </div>
                    </div>
            <?php }
                } else {
                    echo 'No related product available!';
                } ?>

        </div>
    </div>
</div>

<?php } ?>
<!-- first if -->


<?php include 'inc/footer.php' ?>