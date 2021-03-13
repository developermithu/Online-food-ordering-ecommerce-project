<div class="header-bottom transparent-bar black-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li class="top-hover">
                                <a href="<?php echo SITE_PATH ?>" class="<?php if($page == 'home') {echo 'page-active'; } ?>">home</a>
                            </li>

                            <li class="mega-menu-position top-hover"><a href="<?php echo SITE_PATH ?>shop" class="<?php if($page == 'shop') {echo 'page-active'; } ?>">shop
                            </li>
                            <li class="top-hover"><a href="#">pages <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li><a href="<?php echo SITE_PATH ?>shop">shop</a></li>
                                    <li><a href="<?php echo SITE_PATH ?>cart">cart</a></li>
                                    <li><a href="<?php echo SITE_PATH ?>checkout">checkout</a></li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>wishlist">wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>my_account">my account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>order_history">order history
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>login_register"> Register/Login
                                        </a>
                                    </li>
                            </li>
                        </ul>
                        </li>
                        <li><a href="<?php echo SITE_PATH ?>contact-us" class="<?php if($page == 'contact-us') {echo 'page-active'; } ?>">contact us</a></li>
                        <li><a href="<?php echo SITE_PATH ?>about-us" class="<?php if($page == 'about-us') {echo 'page-active'; } ?>">about us</a></li>

                        <?php
                        $login = Session::get('userLogin');
                        if ($login == true) { ?>
                            <li class="user-icon-li">
                                <a href="<?php echo SITE_PATH ?>my_account" class="<?php if($page == 'my_account') {echo 'page-active'; } ?>"> 
                                
                                    <i class="fas fa-user-alt"></i>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- mobile-menu-area-start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow" id="nav">
                            <li><a href="<?php echo SITE_PATH ?>index">home</a>
                            </li>
                            <li><a href="<?php echo SITE_PATH ?>about-us">about</a></li>
                            <li><a href="<?php echo SITE_PATH ?>shop">shop
                            </li>

                            <li><a href="#">pages</a>
                                <ul>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>shop">shop
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>cart">cart
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>checkout">checkout
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>wishlist">wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>my_account">my account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>order_history">order history
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_PATH ?>login_register"> Register/Login
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo SITE_PATH ?>about-us">about us
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_PATH ?>contact-us">contact us
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area-end -->
</header>