<?php
$page = 'my_account';
include 'inc/header.php';
include 'inc/header_bottom.php';

$login = Session::get('userLogin');

if ($login == false) {
    echo '<script> window.location.href = "index"; </script>';
}

?>

<?php
if (isset($_POST['update_btn'])) {
    $updateProfile = $customer->updateUserProfile($_POST, $_FILES);
    if ($updateProfile) {
        echo '<script> window.location.href = "my_account"; </script>';
    }
}
?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active">My Account </li>
            </ul>
        </div>
    </div>
</div>

<!-- User Profile Tab  -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="profile-img-box mr-3">
                <?php
                $userId   = Session::get('userId');
                $query = "SELECT * FROM `tbl_customer` WHERE `id` = '$userId' ";
                $result = $db->select($query);
                $row = $result->fetch_assoc();

                if ($row['image']  == "") { ?>
                    <img src="media/default.webp" alt="" class="profile-sm-img">
                <?php  } else { ?>
                    <img src="<?php echo $row['image'] ?>" alt="" class="profile-sm-img">
                <?php } ?>

                <p class="text-center text-white pt-2 mb-0" style="font-size: 17px;">
                <?php echo $row['name'] ?> <br>
                    <span style="color: #eee;font-size:13px">
                    <?php echo $row['email'] ?>
                </span>
                </p>
            </div>
            <div class="nav flex-column nav-pills mr-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">My Profile</a>
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Password</a>
                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
        </div>

        <div class="col-md-8 col-12 sm-mt-5">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div id="profile">
                        <div class="card">
                            <div class="card-body">
                        <?php 
                        $userId   = Session::get('userId');
                        $query = "SELECT * FROM `tbl_customer` WHERE `id` = '$userId' ";
                        $result = $db->select($query);
                        if ($result) {
                            $row = $result->fetch_assoc(); 
                        ?>
                                <form method="POST" action="" class="form-horizontal form-material" enctype="multipart/form-data">
                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2 ">Email Address :</label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <input type="text" value="<?php echo $row['email'] ?>" class="form-control p-0 border-0" readonly>
                                         </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2 ">Full Name :</label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <input type="text" name="name" value="<?php echo $row['name'] ?>" class="form-control p-0 border-0" required> </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2 "> Mobile Number :</label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <input type="number" name="mobile" value="<?php echo $row['mobile'] ?>" class="form-control p-0 border-0" required> </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2">Short Description</label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <textarea rows="3" class="form-control p-0 border-0" name="short_description">
                                                <?php echo $row['short_description'] ?>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2">Profile Image :</label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <input type="file" name="image" class="form-control p-0 border-0">
                                        </div>
                                    </div>

                                    <!-- <div class="form-row mb-3">
                                            <label class="col-sm-3 col-md-3 mt-2">Select Country</label>
                                            <div class="col-sm-9 border-bottom">
                                                <select class="form-control px-3 border-0">
                                                    <option>London</option>
                                                    <option>India</option>
                                                    <option>Usa</option>
                                                    <option>Canada</option>
                                                    <option>Thailand</option>
                                                </select>
                                            </div>
                                        </div> -->

                                    <div class="form-group update_btn mb-2 mt-4">
                                        <button type="submit" name="update_btn" class="profile-btn px-5 d-inline">Save</button>
                                    </div>
                                </form>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div id="profile">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="post" id="pwd_form" class="form-horizontal form-material">
                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2 "> <b>Old Password :</b></label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <input type="password" id="old_pwd" class="form-control p-0 border-0" placeholder="Type old password..">
                                            <div class="field_error text-danger" id="old_pwd_error">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-md-3 mt-2 "> <b>New Password :</b></label>
                                        <div class="col-md-9 border-bottom p-0">
                                            <input type="password" id="new_pwd" class="form-control p-0 border-0" placeholder="Type new password..">
                                            <div class="field_error text-danger" id="new_pwd_error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group update_btn mb-2 mt-4">
                                        <button type="button" id="pwd_change_btn" onclick="change_password()" class="profile-btn px-5 d-inline">Change</button>
                                        <span class="field_error ml-3" id="final_result"></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="card">
                        <div class="card-body">
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Optio, provident necessitatibus. Rerum, ad veniam natus maiores cupiditate nam est, eveniet ipsum provident, earum itaque perspiciatis iure sapiente. Eum molestiae quibusdam commodi sapiente! Numquam praesentium id quae molestiae facere dignissimos a ipsa deleniti vero in amet voluptas nesciunt nemo, temporibus dolore qui soluta excepturi delectus laboriosam illum asperiores fuga, repellat officiis?</p>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Optio, provident necessitatibus. Rerum, ad veniam natus maiores cupiditate nam est, eveniet ipsum provident, earum itaque perspiciatis iure sapiente. Eum molestiae quibusdam commodi sapiente! Numquam praesentium id quae molestiae facere dignissimos a ipsa deleniti vero in amet voluptas nesciunt nemo, temporibus dolore qui soluta excepturi delectus laboriosam illum asperiores fuga, repellat officiis?</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- row -->
</div> <!-- container -->


<?php include 'inc/footer.php' ?>