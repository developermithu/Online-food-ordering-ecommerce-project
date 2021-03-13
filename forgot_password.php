<?php
include 'inc/header.php';
include 'inc/header_bottom.php';
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH?>">Home</a></li>
                <li class="active"> Forgot Password </li>
            </ul>
        </div>
    </div>
</div>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active">
                            <h4> Forgot Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                <!-- Login Form -->
                                    <form action="#" method="post" id="forgot_form">
                                        <input type="email" id="email" placeholder="Type your email..">
                                        <div class="field_error" id="email_error"></div>

                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <a href="<?php echo SITE_PATH?>login_register">Login</a>
                                            </div>
                                            <button type="button" onclick="forgot_password_btn()" id="forgot_btn"><span>Login</span></button>
                                            <span class="field_error ml-3" id="final_result"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'inc/footer.php' ?>