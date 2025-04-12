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
                                    <a href="pages/all-products.php">All Products</a>
                                </li>                                
                                <li>
                                    <a href="pages/all-industries.php">All Industries</a>
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
        <a href="pages/my-product.php" class="header_icon">
            <i class="fas fa-shopping-basket"></i>
        </a>    
        <a href="#" class="header_icon" id="addProductBtn">
            <i class="fas fa-plus-circle"></i>
        </a>    
        <a href="pages/profile.php" class="header_icon">
          <i class="fas fa-user-edit"></i>
        </a>
        <a href="#" class="header_icon" onclick="logoutUser()" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      `;
    } else {
      iconsWrapper.innerHTML = `
        <a href="login.php" class="header_icon">Login
          <i class="fas fa-sign-in-alt"></i>
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

<!-- For Add Product -->
<script>
    document.getElementById("addProductBtn").addEventListener("click", async function () {
        const authToken = localStorage.getItem("authToken");
        const BASE_URL = "<?php echo BASE_URL; ?>";

        // Fetch dropdown data
        const [unitsRes, industryRes, subIndustryRes] = await Promise.all([
            fetch(`${BASE_URL}/product/get_units`, { headers: { Authorization: authToken } }).then(r => r.json()),
            fetch(`${BASE_URL}/industry`, { headers: { Authorization: authToken } }).then(r => r.json()),
            fetch(`${BASE_URL}/sub_industry`, { headers: { Authorization: authToken } }).then(r => r.json())
        ]);

        const units = unitsRes.data || [];
        const industries = industryRes.data || [];
        const subIndustries = subIndustryRes.data || [];

        let subIndustryOptions = '';

        function updateSubIndustryOptions(selectedIndustryId) {
            subIndustryOptions = subIndustries
                .filter(si => si.slug.startsWith(selectedIndustryId + "_"))
                .map(si => `<option value="${si.id}">${si.name}</option>`)
                .join('');
            document.getElementById('sub_industry').innerHTML = subIndustryOptions;
            document.getElementById('sub_industry').disabled = false;
        }

        const formHtml = `
        <form id="addProductForm" class="swal2-form" style="text-align:left">
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <input name="product_name" class="swal2-input" placeholder="Product Name" required>
                <input name="original_price" class="swal2-input" type="number" step="0.01" placeholder="Original Price" required>
                <input name="selling_price" class="swal2-input" type="number" step="0.01" placeholder="Selling Price" required>
                <input name="offer_quantity" class="swal2-input" type="number" placeholder="Offer Quantity" required>
                <input name="minimum_quantity" class="swal2-input" type="number" placeholder="Minimum Quantity" required>

                <select name="unit" class="swal2-input" required>
                    <option value="">Select Unit</option>
                    ${units.map(u => `<option value="${u}">${u}</option>`).join('')}
                </select>

                <select name="industry" id="industry" class="swal2-input" required>
                    <option value="">Select Industry</option>
                    ${industries.map(i => `<option value="${i.id}">${i.name}</option>`).join('')}
                </select>

                <select name="sub_industry" id="sub_industry" class="swal2-input" disabled required>
                    <option value="">Select Sub-Industry</option>
                </select>

                <input name="dimensions" class="swal2-input" placeholder="Dimensions (e.g., 50mm x 20mm x 35mm)">
                <input name="city" class="swal2-input" placeholder="City">
                <input name="state_id" class="swal2-input" type="number" placeholder="State ID">

                <textarea name="description" class="swal2-textarea" placeholder="Product Description"></textarea>

                <label style="margin: 5px 0;">Product Image</label>
                <input type="file" name="image" accept="image/*" class="swal2-file">
            </div>
        </form>`;

        await Swal.fire({
            title: 'Add Product',
            html: formHtml,
            confirmButtonText: 'Submit',
            confirmButtonColor: '#e3342f', // red
            showCancelButton: true,
            didOpen: () => {
                document.getElementById('industry').addEventListener('change', function () {
                    updateSubIndustryOptions(this.value);
                });
            },
            preConfirm: async () => {
                const form = document.getElementById('addProductForm');
                const formData = new FormData(form);

                const body = {
                    product_name: formData.get('product_name'),
                    original_price: parseFloat(formData.get('original_price')),
                    selling_price: parseFloat(formData.get('selling_price')),
                    offer_quantity: parseInt(formData.get('offer_quantity')),
                    minimum_quantity: parseInt(formData.get('minimum_quantity')),
                    unit: formData.get('unit'),
                    industry: parseInt(formData.get('industry')),
                    sub_industry: parseInt(formData.get('sub_industry')),
                    description: formData.get('description'),
                    dimensions: formData.get('dimensions'),
                    city: formData.get('city'),
                    state_id: parseInt(formData.get('state_id')),
                    // Optional: Add image base64 if needed
                };

                try {
                    const response = await fetch(`${BASE_URL}/product/create`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: authToken
                        },
                        body: JSON.stringify(body)
                    });

                    const res = await response.json();
                    if (!res.success) throw new Error(res.message);
                    return res;
                } catch (error) {
                    Swal.showValidationMessage(`Failed: ${error.message}`);
                }
            }
        }).then(result => {
            if (result.isConfirmed && result.value?.success) {
                Swal.fire('Success!', result.value.message, 'success');
            }
        });
    });
</script>