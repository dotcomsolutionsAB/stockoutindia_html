<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Stockout India</title>
    <script src="configs/auth.js"></script>
    <!-- <script src="loader?f=auth-js" type="text/javascript"></script> -->
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
    
    <!-- <script src="loader?f=locked-js" type="text/javascript"></script> -->
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/demo27.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/simple-line-icons/css/simple-line-icons.min.css">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

    <!-- Razorpay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <link rel="stylesheet" href="custom/custom.css">
    <link rel="stylesheet" href="custom/responsive.css">
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
                        <a href="index" class="logo">
                            <img src="uploads/logo.jpg" alt="Stock Out" width="111" height="44">
                        </a>
                        <nav class="main-nav">
                            <ul class="menu">
                                <li class="active">
                                    <a href="index">Home</a>
                                </li>
                                <li>
                                    <a href="pages/all-products">Products</a>
                                </li>                                
                                <li>
                                    <a href="pages/all-industries">Industries</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="header-right">
                        <!-- Search bar (always visible) -->
                        <!-- <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right d-none d-sm-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <form action="#" method="get">
                            <div class="header-search-wrapper">
                                <input type="search" class="form-control" name="q" id="q" placeholder="I'm searching for..." required>
                                <div class="select-custom font2">
                                <select id="industry" name="industry">
                                    <option value="">All Industries</option>
                                </select>
                                </div>
                                <button class="btn icon-magnifier" title="search" type="submit"></button>
                            </div>
                            </form>
                        </div> -->
                        <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right d-none d-sm-block position-relative">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>

                            <form id="searchForm" action="" method="GET">
                                <div class="header-search-wrapper">
                                <input type="search" class="form-control" name="id" id="q" placeholder="I'm searching for..." autocomplete="off" >
                                    
                                <button class="btn icon-magnifier" title="search" type="submit"></button>
                                </div>

                                <!-- Live results -->
                                <div id="liveResults" class="position-absolute result_box" style="z-index:9999; display: none;">

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

            <!-- <div class="header-bottom">
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
                        </div>
                    </div>

                    <div class="info-box info-box-icon-left">
                        <i class="icon-money text-white"></i>

                        <div class="info-box-content">
                            <h4 class="text-white">Money Back Guarantee</h4>
                        </div>
                    </div>

                    <div class="info-box info-box-icon-left">
                        <i class="icon-support text-white"></i>

                        <div class="info-box-content">
                            <h4 class="text-white">Online Support 24/7</h4>
                        </div>
                    </div>
                </div>
            </div> -->
            
        </header>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const iconsWrapper = document.getElementById("header-auth-icons");
    const authToken = localStorage.getItem("authToken");

    if (authToken) {
      iconsWrapper.innerHTML = `      
        <a href="pages/account" class="header_icon">
          <i class="fas fa-user-edit"></i>
        </a>
        <a href="pages/account?tab=addProducts" class="header_icon add_pros">
            <span>List Product</span>
            <i class="fas fa-plus-circle"></i>
        </a>
      `;
    } else {
      iconsWrapper.innerHTML = `
        <a href="login" class="header_icon">
          <i class="fas fa-user"></i>
        </a>
        <a href="login" class="header_icon add_pros">
            <span>List Product</span>
          <i class="fas fa-plus-circle"></i>
        </a>
      `;
    }
  });
</script>


<script>
    const BASE_URL = "https://api.stockoutindia.com/api";
    const authToken = localStorage.getItem("authToken");

    const headers = {
        "Content-Type": "application/json"
    };
    if (authToken) headers["Authorization"] = `Bearer ${authToken}`;

    const inputField = document.getElementById("q");
    const resultBox = document.getElementById("liveResults");
    let typingTimer;

    // Live search logic
    inputField.addEventListener("input", function () {
        const query = this.value.trim();
        clearTimeout(typingTimer);

        if (query.length > 2) {
            typingTimer = setTimeout(() => {
                fetch(`${BASE_URL}/get_products`, {
                    method: "POST",
                    headers,
                    body: JSON.stringify({ search: query, limit: 5, offset: 0 })
                })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success && result.data.length > 0) {
                            const html = result.data.map(product => `
                                <div class="bar_result border-bottom">
                                    <a href="pages/product_detail?id=${encodeURIComponent(product.id)}" class="text-dark d-block">
                                        ${product.product_name}
                                    </a>
                                </div>
                            `).join('');
                            resultBox.innerHTML = html;
                            resultBox.style.display = 'block';
                        } else {
                            resultBox.innerHTML = '<div class="px-3 py-2 text-muted">No products found.</div>';
                            resultBox.style.display = 'block';
                        }
                    });
            }, 400);
        } else {
            resultBox.style.display = 'none';
        }
    });

    // Handle submit on search button
    document.getElementById("searchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const query = inputField.value.trim();
        if (query.length === 0) return;

        const endpoint = authToken
            ? `${BASE_URL}/product/get_products`
            : `${BASE_URL}/get_products`;

        fetch(endpoint, {
            method: "POST",
            headers,
            body: JSON.stringify({ search: query, limit: 1, offset: 0 })
        })
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data.length > 0) {
                    const productId = result.data[0].id;
                    window.location.href = `pages/product_detail?id=${productId}`;
                } else {
                    alert("No matching product found.");
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert("Something went wrong while searching.");
            });
    });

    // Hide live results on outside click
    document.addEventListener("click", (e) => {
        if (!document.getElementById("searchForm").contains(e.target)) {
            resultBox.style.display = "none";
        }
    });
</script>

