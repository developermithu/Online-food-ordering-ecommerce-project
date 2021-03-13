<?php 
session_start();
if (isset($_SESSION['DELIVERY_BOY_LOGIN'])) {
    header("location: index.php");
}
 ?>

<!DOCTYPE php>
<php lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Delivery Boy - Login</title>

    <!-- Fontfaces CSS-->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;900&display=swap" rel="stylesheet">
    <link href="../admin/assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="../admin/assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <!-- Bootstrap CSS-->
    <link href="../admin/assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <!-- assets/Vendor CSS-->
    <link href="../admin/assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../admin/assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="../admin/assets/css/theme.css" rel="stylesheet" media="all">
     <link href="../admin/assets/css/custom.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <!-- <img src="assets/images/icon/logo.png" alt="CoolAdmin"> -->
                                Delivery Boy
                            </a>
                        </div>
                        <div class="login-form">
                            <!-- Login Form -->
                            <form action="" method="post">
                                <div class="form-group">
                                    <label><strong>Mobile</strong></label>
                                    <input class="au-input au-input--full" type="number" placeholder="Mobile.." id="mobile">
                                </div>
                                <div class="form-group">
                                    <label><strong>Password</strong></label>
                                    <input class="au-input au-input--full" type="password" placeholder="Password.." id="password">
                                </div>

                                    <label>
                                        <a href="forgot-pass.php">Forgot Password?</a>
                                    </label>

                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="button" id="submitBtn" onclick="delivery_boy_login()">log in</button>
                                <p id="showMsg" class="mb-3"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="../admin/assets/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../admin/assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../admin/assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    </script>
    <script src="../admin/assets/vendor/wow/wow.min.js"></script>
    <script src="../admin/assets/vendor/animsition/animsition.min.js"></script>


    <script src="assets/js/main.js"></script>
    <script>
        function delivery_boy_login(){
            var mobile     = $('#mobile').val();
            var password = $('#password').val();
            $.ajax({
                url: 'get_delivery_boy_login.php',
                type: 'post',
                data: {mobile:mobile, password:password},
                success: function (result){
                      if ( result == "success" ) {
                        window.location.href = "index.php";
                      }else{
                          $('#showMsg').html(result);
                      }
                }
            });
        }
    </script>
</body>
</html>
