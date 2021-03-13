<?php
include 'inc/header.php';
include 'inc/header_bottom.php';
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH?>">Home</a></li>
                <li class="active"> Login / Register </li>
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
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                        <a data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                <!-- Login Form -->
                                    <form action="#" method="post" id="login_form">
                                        <input type="email" id="user_email" placeholder="Your email">
                                        <div class="field_error" id="user_email_error"></div>

                                        <input type="password" id="user_password" placeholder="your password">
                                        <div class="field_error" id="user_password_error"></div>

                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox">
                                                <label>Remember me</label>
                                                <a href="<?php echo SITE_PATH?>forgot_password">Forgot Password?</a>
                                            </div>
                                            <button type="button" onclick="customer_login()" id="login_btn"><span>Login</span></button>
                                            <span class="field_error ml-3" id="final_error"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                <!-- Registration form -->
                                    <form action="#" method="post" id="regForm">
                                        <input type="text" id="regName" placeholder="Your name..">
                                        <div class="field_error" id="regNameError"></div>
                                        <input type="email" id="regEmail" placeholder="Your email..">
                                        <div class="field_error" id="regEmailError"></div>
                                        <input type="number" id="regMobile" placeholder="Mobile number.." >
                                        <div class="field_error" id="regMobileError"></div>
                                        <input type="password" id="regPassword" placeholder="Password.." >
                                        <div class="field_error" id="regPasswordError"></div>

                                        <div class="button-box">
                                            <button type="button" id="regBtn" onclick="customer_registration()"><span>Register</span></button>
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