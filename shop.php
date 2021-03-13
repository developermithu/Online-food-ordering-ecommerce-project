<?php
$page = 'shop';
include 'inc/header.php';
include 'inc/header_bottom.php';

$dish_cat = "";
$type = "";
$search_type = "";
$dish_cat_arr = array();

if (isset($_GET['dish_cat'])) {
    $dish_cat = $_GET['dish_cat'];
    $dish_cat_arr = array_filter(explode(':', $dish_cat));  //array_filter [0] remove kore
    $dish_cat_str = implode(",", $dish_cat_arr);
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

if (isset($_GET['search_type'])) {
    $search_type = $_GET['search_type'];
}

$typeArray = array('veg', 'non-veg', 'both');
?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active">Shop Grid Style </li>
            </ul>
        </div>
    </div>
</div>

<?php
if ($website_close == 1) {
    echo "<div class='mt-4'><h2 class='mt-4 text-danger text-center text-uppercase'>$website_close_msg</h2></div>";
}
?>

<div class="shop-page-area pt-60 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">

                <div class="product-sorting">
                    <div class="list">
                        <?php
                        foreach ($typeArray as $value) {
                            $radio_checked = "";
                            if ($value == $type) {
                                $radio_checked = "checked";
                            }
                        ?>
                            <?php echo strtoupper($value) ?> <input <?php echo $radio_checked ?> type="radio" name="type" value="<?php echo $value ?>" onclick="setFoodType('<?php echo $value ?>')">
                        <?php } ?>
                    </div>
                    <div class="search-box">
                        <input type="text" class=" form-control" placeholder="Search.." id="search" value="<?php echo $search_type ?>">
                        <button type="button" class="btn btn-info ml-3 py-1" onclick="setSearch()">Search</button>
                    </div>
                </div>

                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <div class="row">

                            <!-- Single Product -->
                            <?php
                            $id = "";
                            $query = "SELECT * FROM `tbl_dish` WHERE `status` = '0' ";
                            if (isset($_GET['cat_id']) && $_GET['cat_id'] > 0) {
                                $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['cat_id']);
                                $query .= "AND `category_id` = '$id' ";
                            }
                            if ($dish_cat != "") {
                                $query .= "AND `category_id` IN ($dish_cat_str) ";
                            }
                            if ($type != "" && $type != 'both') {
                                $query .= "AND `type` = '$type' ";
                            }
                            if ($search_type != "") {
                                $query .= "AND (`dish` LIKE '%$search_type%' OR `dish_details` LIKE  '%$search_type%' )";
                            }

                            $query .= "ORDER BY `dish` ASC ";
                            $result = $db->select($query);
                            if ($result) {
                                while ($row = $result->fetch_assoc()) { ?>

                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                        <div class="product-wrapper">
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
                                                    <a href="<?php echo SITE_PATH ?>product_details?id=<?php echo $row['id'] ?>">
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
                                            <!-- Single Product -->
                                        </div>
                                    </div>
                            <?php }
                            } else {
                                echo '<div class="not_found">Product Not Found!</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <h4 class="shop-sidebar-title">Shop By Multiple Category</h4>
                    <!-- Checkbox Filter Multiple category -->
                    <div class="shop-widget mt-15 shop-sidebar-border">

                        <div class="sidebar-list-style multiple-category-list mt-15">
                            <ul>
                                <a href="<?php echo SITE_PATH ?>shop">Clear</a>
                                <?php
                                $getCategory = $category->getCategoryByStatus();
                                if ($getCategory) {
                                    while ($row = $getCategory->fetch_assoc()) {

                                        $checked = "";
                                        if (in_array($row['id'], $dish_cat_arr)) {
                                            $checked = 'checked';
                                        }
                                ?>
                                        <li>
                                            <input <?php echo $checked ?> type="checkbox" onclick="set_checkbox(<?php echo $row['id'] ?>)" value="<?php echo $row['id'] ?>" name="cat_arr[]">
                                            <?php echo $row['catName'] ?>
                                        </li>
                                <?php  }
                                } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-price-filter mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Price Filter</h4>
                        <div class="price_filter mt-25">
                            <span>Range: $100.00 - 1.300.00 </span>
                            <div id="slider-range"></div>
                            <div class="price_slider_amount">
                                <div class="label-input">
                                    <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                </div>
                                <button type="button">Filter</button>
                            </div>
                        </div>
                    </div>

                    <!-- show 5 category -->
                    <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                        <h4 class="shop-sidebar-title">Popular Tags</h4>
                        <div class="shop-tags mt-25">
                            <ul>
                                <?php
                                $getCategory = $category->getCategoryByStatus();
                                if ($getCategory) {
                                    while ($row = $getCategory->fetch_assoc()) {
                                        $class = "selected";
                                        if ($id == $row['id']) {
                                            $class = 'active';
                                        }
                                ?>
                                        <li> <a class="<?php echo $class; ?>" href="<?php echo SITE_PATH ?>shop?cat_id=<?php echo $row['id'] ?>"> <?php echo $row['catName'] ?> </a>
                                        </li> <!-- shop.php?cat_id= check .htaccess -->
                                <?php  }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="get" id="dish_cat_form">
    <input type="hidden" name="dish_cat" id="dish_cat" value="<?php echo $dish_cat; ?>">
    <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
    <input type="hidden" name="search_type" id="search_type" value="<?php echo $search_type; ?>">
</form>


<?php include 'inc/footer.php' ?>