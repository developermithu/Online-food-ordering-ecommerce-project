<?php include 'inc/header.php' ?>
<?php include 'inc/sidebar.php' ?>

<?php
if (isset($_POST['submit'])) {
    $addSlider = $proccess->addSlider($_POST);
    if ($addSlider) {
        // echo '<script>window.location.href = "slider.php"; </script>';
        header('location: slider.php');
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
                            <h2 class="title-1">Slider List</h2>
                            <!-- Button trigger modal -->
                            <a href="slider.php" class="au-btn au-btn-icon au-btn--blue">Back</a>
                        </div>
                    </div>
                </div>

                <div class="row m-t-40">
                    <div class="col-md-12">
                        <form action="" method="post" class="form-horizontal bg-light px-4 py-5" enctype="multipart/form-data">

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Slider Title*</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="title" class="form-control" placeholder="Slider title.." required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Sub Title *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="sub_title" class="form-control" placeholder="Sub title.." required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Button Link *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="link" class="form-control" placeholder="example.php" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Button Text *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="link_text" class="form-control" placeholder="Order now.." required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-2">
                                    <label class=" form-control-labe"><strong>Slider Image *</strong></label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="file" name="image" class="form-control" required>
                                    <small class="text-danger">Allowed only: jpg, png, jpeg (less than 1mb).</small>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary px-4 mt-2" style="margin-left: 170px;">Submit</button>

                            <?php
                            if (isset($addSlider)) {
                                echo $addSlider;
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'inc/footer.php' ?>