<?php
$page = 'contact-us';
include 'inc/header.php';
include 'inc/header_bottom.php';
?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo SITE_PATH ?>">Home</a></li>
                <li class="active"> Contact Us </li>
            </ul>
        </div>
    </div>
</div>

<div class="contact-area pt-50 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Our Location</h4>
                        <p>Mirzazangal, Sylhet, Bangladesh</p>
                        <p><a href="#">developermithu@gmail.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon mb-0">
                        <i class="fas fa-phone-alt"></i>
                        <div class="contact-info-content mt-4">
                            <h4>Contact us Anytime</h4>
                            <p>Mobile: 018-11797089</p>
                            <p>Fax: 123 456 789</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Write Some Words</h4>
                        <p><a href="#">Support24/7@example.com </a></p>
                        <p><a href="#">info@example.com</a></p>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="contact-message-wrapper">
                    <h4 class="contact-title">GET IN TOUCH</h4>
                    <div class="contact-message">
                        <!-- Form -->
                        <form id="contact_form" action="#" method="post">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input type="text" id="name" placeholder="Your name..">
                                        <div class="field_error" id="name_error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input type="email" id="email" placeholder="Your email..">
                                        <div class="field_error" id="email_error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-form-style mb-20">
                                        <input type="text" id="subject" placeholder="Your subject..">
                                        <div class="field_error" id="subject_error"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-form-style">
                                        <textarea id="message" placeholder="Message.."></textarea>
                                        <div class="field_error" id="message_error"></div>

                                        <button class="submit btn-style" type="button" onclick="send_message()">SEND MESSAGE</button>
                                    </div>
                                    <div class="field_error ml-3" id="final_result"></div>
                                </div>

                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="contact-map">
                    <div id="map"></div>
                </div> -->
    </div>
</div>


<?php include 'inc/footer.php' ?>