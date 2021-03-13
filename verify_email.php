<?php
include 'inc/header.php';
include 'inc/header_bottom.php';

$msg = '';
    if ( isset($_GET['verify_id']) && $_GET['verify_id'] != "") {
        $verify_id = $_GET['verify_id'];
        $query = "UPDATE `tbl_customer` SET `email_verify` = '1' WHERE `rand_string` = '$verify_id' ";
        $result = $db->update($query);
        if ($result) {
          $msg = '<div class="text-center text-success">Email id verified successfully.</div>';
        }
    }else{
        echo '<script>window.location = "index.php"; </script>';
    }

?>



<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH?>">Home</a></li>
                <li class="active"> Verify Email</li>
            </ul>
        </div>
    </div>
</div>
<div class="login-register-area pt-95 pb-100">

<h2> <?php echo $msg; ?> </h2>

</div>


<?php include 'inc/footer.php' ?>