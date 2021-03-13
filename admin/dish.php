<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'inc/topbar.php' ?>
    <!-- HEADER DESKTOP-->

    <?php
    // Deactive 
    if (isset($_GET['deactive_id']) && $_GET['deactive_id'] != "") {
        $deactive_id = $_GET['deactive_id'];
        $deactive = $dish->deactiveDish($deactive_id);
        if ($deactive) {
            echo '<script>window.location = "dish.php"; </script>';
        }
    }

    // Active 
    if (isset($_GET['active_id']) && $_GET['active_id'] != "") {
        $active_id = $_GET['active_id'];
        $active = $dish->activeDish($active_id);
        if ($active) {
            echo '<script>window.location = "dish.php"; </script>';
        }
    }

    // Delete 
    if (isset($_GET['delete_id']) && $_GET['delete_id'] != "") {
        $delete_id = $_GET['delete_id'];
        $deleteDish = $dish->deleteDish($delete_id);
        if ($deleteDish) {
            echo '<script>window.location = "dish.php"; </script>';
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
                            <h2 class="title-1">Dish List</h2>
                            <!-- Button trigger modal -->
                            <a href="dish_add.php" class="au-btn au-btn-icon au-btn--blue">
                                </i>add dish</a>
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
                                        <th>Category</th>
                                        <th>Dish</th>
                                        <th>Image</th>
                                        <th>Dish Details</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $getDishData = $dish->getDishData();
                                    if ($getDishData) {
                                        $i = 0;
                                        while ($row = $getDishData->fetch_assoc()) {
                                            $type = $row['type'];
                                            $i++;
                                    ?>

                                            <tr class="text-center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['catName'] ?></td>
                                                <td><?php echo $row['dish'] ?>(<?php
                                                                                if ($type == "non-veg") {
                                                                                    echo 'Non-Veg';
                                                                                } else {
                                                                                    echo 'Veg';
                                                                                }
                                                                                ?>)</td>
                                                <td><a href="<?php echo $row['image'] ?>"><img src="<?php echo $row['image'] ?>" width="50px"></a></td>
                                                <td><?php echo $fm->textShorten($row['dish_details'], 20) ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['status'] == 0) { ?>
                                                        <a href="?deactive_id=<?php echo $row["id"] ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure to Deactive?')">Deactive<a>
                                                            <?php  } else { ?>
                                                                <a href="?active_id=<?php echo $row["id"] ?>" class="btn btn-warning btn-sm px-3" onclick="return confirm('Are you sure to Active?')">Active<a>
                                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="dish_edit.php?edit_id=<?php echo $row['id'] ?>" class="item bg-info" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit text-white"></i>
                                                        </a> &nbsp;
                                                        <a href="?delete_id=<?php echo $row['id'] ?>" class="item bg-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure to Delete?')">
                                                            <i class="zmdi zmdi-delete text-white"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
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