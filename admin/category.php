<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'inc/topbar.php' ?>
    <!-- HEADER DESKTOP-->

    <?php
    // Deactive Category
    if (isset($_GET['deactive_id']) && $_GET['deactive_id'] != "") {
        $deactive_id = $_GET['deactive_id'];
        $deactiveCategory = $category->deactiveCategory($deactive_id);
        if ($deactiveCategory) {
            echo '<script>window.location = "category.php"; </script>';
        }
    }

    // Active Category
    if (isset($_GET['active_id']) && $_GET['active_id'] != "") {
        $active_id = $_GET['active_id'];
        $activeCategory = $category->activeCategory($active_id);
        if ($activeCategory) {
            echo '<script>window.location = "category.php"; </script>';
        }
    }

    // Delete Category
    if (isset($_GET['delete_id']) && $_GET['delete_id'] != "") {
        $delete_id = $_GET['delete_id'];
        $deleteCategory = $category->deleteCategory($delete_id);
        if ($deleteCategory) {
            echo '<script>window.location = "category.php"; </script>';
        }
    }

    // Add New Category
    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $addCategory = $category->addNewCategory($_POST);
    // }

    ?>
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Category List</h2>
                            <!-- Button trigger modal -->
                            <button type="button" data-toggle="modal" data-target="#exampleModal" class="au-btn au-btn-icon au-btn--blue">
                                <i class="zmdi zmdi-plus"></i>add category</button>
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
                                        <th>Category Name</th>
                                        <th>Order Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $getCategoryList = $category->getCategoryList();
                                    if ($getCategoryList) {
                                        $i = 0;
                                        while ($row = $getCategoryList->fetch_assoc()) {
                                            $i++;
                                    ?>

                                            <tr class="text-center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['catName'] ?></td>
                                                <td><?php echo $row['order_number'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['status'] == 0) { ?>
                                                        <a href="?deactive_id=<?php echo $row["id"] ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure to Deactivate this category?')">Deactive<a>
                                                            <?php  } else { ?>
                                                                <a href="?active_id=<?php echo $row["id"] ?>" class="btn btn-warning btn-sm px-3" onclick="return confirm('Are you sure to Activate this category?')">Active<a>
                                                                    <?php } ?>

                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="category_edit.php?edit_id=<?php echo $row['id'] ?>" class="item bg-info" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit text-white"></i>
                                                        </a> &nbsp; &nbsp;
                                                        <a href="?delete_id=<?php echo $row['id'] ?>" class="item bg-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure to Delete?')">
                                                            <i class="zmdi zmdi-delete text-white"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo '<td colspan="5" class="not_found">Data not found!</td>';
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
                    <h4 class="modal-title" id="exampleModalLabel">Add New Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        <div class="form-group px-4">
                            <label class="form-control-labe"><strong>Category</strong></label>
                            <input type="text" class="form-control" placeholder="Category name.." id="catName" name="catName">
                        </div>
                        <div class="form-group px-4">
                            <label class=" form-control-labe"><strong>Order Number</strong></label>
                            <input type="number" class="form-control" placeholder="Order Number.." id="order_number" name="order_number">
                        </div>
                </div>
                </form>
                <div class="modal-footer">
                    <span id="showMsg"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="addCategory()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'inc/footer.php' ?>