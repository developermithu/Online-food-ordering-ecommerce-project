<?php
$page = 'about-us';
include 'inc/header.php';
include 'inc/header_bottom.php';
?>
<style>
    strong, b {
        color: #ec0057;
    }
</style>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active"> About Us </li>
            </ul>
        </div>
    </div>
</div>

<div class="contact-area pt-50 pb-40">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-5 col-12">
                <div class="card">
                    <img class="card-img-top" src="admin/media/user/mithu2.jpg" alt="" class="img-fluid">
                    <div class="card-body">
                        <h4 class="card-title text-center" ><strong>Mithu Das</strong></h4>
                        <p class="card-text">
                            <strong class="mr-2">Study :</strong> B.Sc, ZOOLOGY (NU)<br>
                            <strong class="mr-2">Profession :</strong> FULL-STACK WEB DEVELOPER<br>
                            <strong class="mr-2">My Skill :</strong> PHP, LARAVEL, WORDPRESS, MYSQL, AJAX, JSON, JAVACSRIPT, JQUERY, BOOTSTRAP, CSS, SASS, HTML, GIT etc. <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7 col-12">
                <div class="contact-info-wrapper mb-30">
                    <div class="contact-info-content">
                        <h4 class="text-center"><b>ABOUT THIS PROJECT</b></h4>

                        <p class="mt-4"><b>Foody</b> is an <b>Online Food Ordering Website</b> With <b>Delivery Boy System</b> built on <b>OOP PHP</b> and developed by <strong><a href="http://mithu.epizy.com/" style="color: #ec0057;">Mithu</a></strong>. It contains 10+ unique pages that can be customized for any business or creative agency. SEO Optimized, Mobile, Tablet, Desktop & User friendly </p> <br>

                        <p>
                            <strong>Front-End Language : </strong>
                            HTML5, CSS3, SASS, BOOTSTRAP 4, JQUERY, AJAX, JSON. <br><br>

                            <strong>Back-End Language : </strong>
                            OOP PHP, MYSQL DATABASE <br><br>

                            <strong>Functionality : </strong>
                            Contact form, User Login, User Registration, Add to cart, Delivery Boy Assign, Add to Wishlist, Multiple Search Filter, Order History, PDF Invoice, Email Invoice, Email Verification.<br><br>

                            <strong>Payment Method : </strong>
                            Paytm & Cash On Delivery <br><br>

                            <strong>Credits : </strong>
                            <ul class="ml-5">
                                <li>Bootstrap Framework</li>
                                <li> jQuery Library</li>
                                <li>Font Awesome</li>
                                <li>Owl Carousel</li>
                                <li>Google Fonts</li>
                            </ul><br><br>

                            <p style="color:#ec0057 "> <strong>Note :</strong>
                                Payment System is used only for testing purpose not real. So, you can order what you want without investing your money & delivery boy is waiting for you. <i class="fas fa-laugh "></i>
                            </p>

                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php include 'inc/footer.php' ?>