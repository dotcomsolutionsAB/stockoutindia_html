<footer class="footer font2">
            <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" target="_blank" class="whatsapp-sticky" title="Chat on WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <!-- <div class="footer-promo">
                <div class="container">
                    <div class="footer-promo-grid">
                        <div class="footer-promo-item">
                            <img src="uploads/why-choose-stockout.png" alt="Why businesses choose StockOut">
                        </div>
                        <div class="footer-promo-item">
                            <img src="uploads/sell-deadstock-plans.png" alt="Sell your deadstock. Connect with buyers across India.">
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="container">
                <div class="footer-middle">
                    <div class="row">
                        <div class="col-lg-3 foot_ques">
                            <a href="index"><img src="uploads/stockout_logo.png" alt="Logo" class="logo"></a>

                            <!-- <p class="footer-desc">Lorem ipsum dolor sit amet, consectetur adipis.</p> -->

                            <div class="ls-0 footer-question mb-3">
                                <h6 class="mb-0 text-white">Contact</h6>
                                <h3 class="mb-0 text-primary">
                                    <!-- <a href="tel:+918790489293">+91 8790489293</a> -->
                                     <a href="tel:+91<?= SUPPORT_PHONE ?>">+91 <?= SUPPORT_PHONE ?></a>
                                </h3>
                                <p class="footer-desc text-white">
                                    <a href="mailto:<?= SUPPORT_EMAIL ?>"><?= SUPPORT_EMAIL ?></a>
                                </p>
                                <p class="footer-desc text-white">
                                    <strong>Address:</strong> 
                                    <?= COMPANY_ADDRESS ?>
                                </p>
                                <div class="footer-social mt-3">
                                    <a href="<?= INSTAGRAM_URL ?>" target="_blank" rel="noopener" class="footer-social-icon" title="Follow us on Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Account</h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="links">
                                            <li><a href="pages/account">Profile</a></li>
                                            <li><a href="pages/all-products">Products</a></li>
                                            <li><a href="pages/all-industries">Industries</a></li>
                                            <li><a href="pages/account?tab=wishlist">Wishlist</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">About</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="links">
                                            <li><a href="pages/about-us">About Us</a></li>
                                            <li><a href="pages/faq">FAQs</a></li>
                                            <li><a href="pages/privacy-policy">Privacy Policy</a></li>
                                            <li><a href="pages/refund-policy">Refund Policy</a></li>
                                            <li><a href="pages/terms-condition">Terms & Conditions</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <!-- === App-download widget (replaces the old Features widget) === -->
                        <div class="col-lg-3">
                            <div class="widget text-lg-right">
                                <h4 class="widget-title mb-3">Get the App</h4>

                                <!-- Google Play -->
                                <a href="<?= PLAYSTORE_URL ?>"
                                    target="_blank" rel="noopener" class="d-inline-block">
                                    <img src="uploads/appImage2.png" alt="Get it on Google Play"
                                        class="img-fluid" style="max-width: 165px;">
                                </a>

                                <!-- App Store -->
                                <a href="<?= APPSTORE_URL ?>" target="_blank" rel="noopener" class="d-inline-block">
                                    <img src="uploads/appImage1.png"
                                        alt="Download on the App Store" class="img-fluid" style="max-width: 165px;">
                                </a>
                            </div>
                        </div>

                        <!-- <div class="col-lg-3">
                            <div class="widget text-lg-right">
                                <h4 class="widget-title">Features</h4>

                                <ul class="links">
                                    <li><a href="#">Buy Product</a></li>
                                    <li><a href="#">Sell Your Product</a></li>
                                </ul>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="footer-bottom">
                    <p class="footer-copyright text-lg-center mb-0">&copy; Stockout India. 2025. All Rights
                        Reserved
                    </p>
                </div><!-- End .footer-bottom -->
            </div><!-- End .container -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li><a href="index">Home</a></li>
                    <li>
                        <a href="pages/all-products">Products</a>
                    </li>
                    <li>
                        <a href="pages/all-industries">Industries</a>
                    </li>
                    <li>
                        <a href="pages/about-us">About Us</a>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <!-- <form class="search-wrapper mb-2" action="#">
                <input type="text" class="form-control mb-0" placeholder="Search..." required />
                <button class="btn icon-search text-white bg-transparent p-0" type="submit"></button>
            </form>

            <div class="social-icons">
                <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
                </a>
                <a href="#" class="social-icon social-twitter icon-twitter" target="_blank">
                </a>
                <a href="#" class="social-icon social-instagram icon-instagram" target="_blank">
                </a>
            </div> -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    <div class="sticky-navbar">
        <div class="sticky-info">
            <a href="index">
                <i class="icon-home"></i>Home
            </a>
        </div>

        <div class="sticky-info">
            <a href="pages/all-industries">
                <i class="icon-bars"></i>Industries
            </a>
        </div>

        <div class="sticky-info">
            <a href="pages/account">
                <i class="icon-user-2"></i>Account
            </a>
        </div>

        <!-- Wishlist  ➜  account?tab=wishlist -->
        <div class="sticky-info">
            <a href="pages/account?tab=wishlist">
                <i class="icon-heart"></i>Wishlist
            </a>
        </div>
    </div>



    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    <!-- Home page slider -->
    <!--<script src="custom/script.js"></script>-->
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/optional/isotope.pkgd.min.js"></script>
    <script src="assets/js/jquery.appear.min.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>


    <!-- Main JS File -->
    <script src="assets/js/main.min.js"></script>
</body>
</html>