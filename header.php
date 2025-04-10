<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>StockOut</title>
    <meta name="description" content="StockOut">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
    <script>
        WebFontConfig = {
            google: { families: [ 'Open+Sans:300,400,600,700,800', 'Poppins:200,300,400,500,600,700,800', 'Oswald:300,600,700', 'Playfair+Display:700' ] }
        };
        ( function ( d ) {
            var wf = d.createElement( 'script' ), s = d.scripts[ 0 ];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore( wf, s );
        } )( document );
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/demo27.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/simple-line-icons/css/simple-line-icons.min.css">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        
    <link rel="stylesheet" href="custom/custom.css">
</head>

<body>
    <div class="page-wrapper">

        <header class="header">
            <div class="header-middle sticky-header">
                <div class="container">

                    <div class="header-left">
                        <button class="mobile-menu-toggler" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <a href="demo27.html" class="logo">
                            <img src="uploads/logo.jpg" alt="Stock Out" width="111" height="44">
                        </a>
                        <nav class="main-nav">
                            <ul class="menu">
                                <li class="active">
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="all-products.php">All Products</a>
                                </li>
                                <li class="d-none d-xxl-block">
                                    <a href="all-industries.php">All Industries</a>
                                </li>
                                <!-- <li class="d-none d-xxl-block">
                                    <a href="all-industries.php">All Industries</a>
                                </li> -->
                                <li>
                                    <a href="#">Pages</a>
                                    <ul>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="cart.html">Shopping Cart</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="header-right">
                        <!-- Search bar (always visible) -->
                        <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right d-none d-sm-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <form action="#" method="get">
                            <div class="header-search-wrapper">
                                <input type="search" class="form-control" name="q" id="q" placeholder="I'm searching for..." required>
                                <div class="select-custom font2">
                                <select id="cat" name="cat">
                                    <option value="">All Categories</option>
                                    <option value="4">Fashion</option>
                                    <option value="12">- Women</option>
                                    <option value="13">- Men</option>
                                </select>
                                </div>
                                <button class="btn icon-magnifier" title="search" type="submit"></button>
                            </div>
                            </form>
                        </div>

                        <!-- Auth-based icons -->
                        <div id="header-auth-icons" class="flex gap-3 items-center">
                            <!-- JS will inject links here -->
                        </div>
                    </div>

                </div>
            </div>

            <div class="header-bottom">
                <div class="owl-carousel info-boxes-slider" data-owl-options="{
                        'items': 1,
                        'dots': false,
                        'loop': false,
                        'responsive': {
                            '768': {
                                'items': 2
                            },
                            '992': {
                                'items': 3
                            }
                        }
                    }">
                    <div class="info-box info-box-icon-left">
                        <i class="icon-shipping text-white"></i>

                        <div class="info-box-content">
                            <h4 class="text-white">Free Shipping &amp; Return</h4>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                    <div class="info-box info-box-icon-left">
                        <i class="icon-money text-white"></i>

                        <div class="info-box-content">
                            <h4 class="text-white">Money Back Guarantee</h4>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                    <div class="info-box info-box-icon-left">
                        <i class="icon-support text-white"></i>

                        <div class="info-box-content">
                            <h4 class="text-white">Online Support 24/7</h4>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->
                </div><!-- End .owl-carousel -->
            </div>
        </header>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const iconsWrapper = document.getElementById("header-auth-icons");
    const authToken = localStorage.getItem("authToken");

    if (authToken) {
      iconsWrapper.innerHTML = `
        <a href="cart.php" class="header-icon">
          <i class="minicart-icon line-height-1"></i>
        </a>
        <a href="pages/profile.php" class="header-icon">
          <i class="icon-user-2 line-height-1"></i>
        </a>
        <a href="#" class="header-icon" onclick="logoutUser()" title="Logout">
          Logout
        </a>
      `;
    } else {
      iconsWrapper.innerHTML = `
        <a href="login.php" class="header-icon">
          <i class="icon-user-2 line-height-1"></i>
        </a>
      `;
    }
  });

  function logoutUser() {
    localStorage.removeItem("authToken");
    localStorage.removeItem("user_id");
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    localStorage.removeItem("name");

    window.location.href = "login.php";
  }
</script>
