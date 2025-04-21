<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Stockout India</title>
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
    <!-- <script src="configs/auth.js"></script> -->
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
                        <a href="index.php" class="logo">
                            <img src="uploads/logo.jpg" alt="Stock Out" width="111" height="44">
                        </a>
                        <nav class="main-nav">
                            <ul class="menu">
                                <li class="active">
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="pages/all-products.php">Products</a>
                                </li>                                
                                <li>
                                    <a href="pages/all-industries.php">Industries</a>
                                </li>
                                <!-- <li class="d-none d-xxl-block">
                                    <a href="all-industries.php">All Industries</a>
                                </li> -->
                                <!-- <li>
                                    <a href="#">Pages</a>
                                    <ul>
                                        <li><a href="wishlist.html">Wishlist</a></li>
                                        <li><a href="cart.html">Shopping Cart</a></li>
                                    </ul>
                                </li> -->
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
                                
                                <!-- <div class="select-custom font2">
                                    <select id="industry" name="industry">
                                    <option value="">All Industries</option>
                                    </select>
                                </div> -->
                                
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
        <a href="pages/account.php" class="header_icon">
          <i class="fas fa-user-edit"></i>
        </a>
      `;
    } else {
      iconsWrapper.innerHTML = `
        <a href="login.php" class="header_icon">
          <i class="fas fa-user"></i>
        </a>
      `;
    }
  });
</script>


<!-- <a href="#" class="header_icon" id="addProductBtn">
    <i class="fas fa-plus-circle"></i>
</a> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const BASE_URL = "https://api.stockoutindia.com/api"; 
        const authToken = localStorage.getItem("authToken");

        const addBtn = document.getElementById("addProductBtn");
        if (!addBtn || !authToken) return;

        addBtn.addEventListener("click", async function () {
            const formHtml = `
            <style>
                .alert_box_footer{
                    display: flex    ;
                    justify-content: space-between;
                    gap: 10px;
                }
                .alert_box_footer textarea{
                    width: 66%;
                    margin-top: 15px;
                    border: 1px solid #cccccc;
                    border-radius: 5px;
                    padding: 10px;
                }
                .alert_box_footer textarea{
                    margin-top: 15px;
                    margin-right: 30px;
                }
                .swal2-popup { width: 900px !important; }
                .swal2-form-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 15px;
                }
                .swal2-form-grid input,
                .swal2-form-grid select,
                .swal2-form-grid textarea {
                    width: 100% !important;
                    font-size: 14px !important;
                    padding: 8px 10px;
                    border-radius: 5px;
                    border: 1px solid #ccc;
                }
                .upload-box {
                    border: 2px dashed #ccc;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                    cursor: pointer;
                    background: #fafafa;
                    transition: border-color 0.3s;
                }
                .upload-box:hover {
                    border-color: #e3342f;
                }
                .upload-box i {
                    font-size: 28px;
                    margin-bottom: 5px;
                    color: #e3342f;
                }
            </style>

            <form id="addProductForm" class="swal2-form">
                <div class="swal2-form-grid">
                    <input name="product_name" placeholder="Product Name" required>
                    <input name="original_price" type="number" step="0.01" placeholder="Original Price" required>
                    <input name="selling_price" type="number" step="0.01" placeholder="Selling Price" required>
                    
                    <input name="offer_quantity" type="number" placeholder="Offer Quantity" required>
                    <input name="minimum_quantity" type="number" placeholder="Minimum Quantity" required>
                    <select name="unit" id="unit" required>
                        <option value="">Loading Units...</option>
                    </select>

                    <select name="industry" id="industry" required>
                        <option value="">Loading Industries...</option>
                    </select>

                    <select name="sub_industry" id="sub_industry" disabled required>
                        <option value="">Select Sub-Industry</option>
                    </select>

                    <select name="state_id" id="state_id" required>
                        <option value="">Loading States...</option>
                    </select>

                    <select name="city" id="city" disabled required>
                        <option value="">Select City</option>
                    </select>

                    <input name="dimensions" placeholder="Dimensions (e.g., 50mm x 20mm x 35mm)">
                </div>
                <div class="alert_box_footer">
                    <textarea name="description" rows="3" placeholder="Product Description"></textarea>
                    <label for="imageUpload" class="upload-box">
                        <i class="fas fa-upload"></i><br>
                        Click to upload Product Image
                        <input type="file" name="image" accept="image/*" id="imageUpload" style="display:none">
                    </label>
                </div>
                
            </form>`;

            await Swal.fire({
                title: 'Add Product',
                html: formHtml,
                confirmButtonText: 'Submit',
                confirmButtonColor: '#e3342f',
                showCancelButton: true,
                didOpen: async () => {
                    // Make image clickable
                    document.querySelector('.upload-box').addEventListener('click', () => {
                        document.getElementById('imageUpload').click();
                    });

                    const unitSelect = document.getElementById('unit');
                    const industrySelect = document.getElementById('industry');
                    const subIndustrySelect = document.getElementById('sub_industry');
                    const stateSelect = document.getElementById('state_id');
                    const citySelect = document.getElementById('city');

                    let subIndustriesAll = [];
                    let citiesAll = [];

                    // Fetch Units
                    try {
                        const res = await fetch(`${BASE_URL}/product/get_units`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        const units = (await res.json()).data || [];
                        unitSelect.innerHTML = '<option value="">Select Unit</option>' +
                            units.map(u => `<option value="${u}">${u}</option>`).join('');
                    } catch {
                        unitSelect.innerHTML = '<option value="">Failed to load</option>';
                    }

                    // Fetch Industries
                    try {
                        const res = await fetch(`${BASE_URL}/industry`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        const industries = (await res.json()).data || [];
                        industrySelect.innerHTML = '<option value="">Select Industry</option>' +
                            industries.map(i => `<option value="${i.id}">${i.name}</option>`).join('');
                    } catch {
                        industrySelect.innerHTML = '<option value="">Failed to load</option>';
                    }

                    // Fetch Sub-Industries
                    try {
                        const res = await fetch(`${BASE_URL}/sub_industry`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        subIndustriesAll = (await res.json()).data || [];
                    } catch {
                        console.error("Sub-industries failed");
                    }

                    // Fetch States
                    try {
                        const res = await fetch(`${BASE_URL}/states`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        const states = (await res.json()).data || [];
                        stateSelect.innerHTML = '<option value="">Select State</option>' +
                            states.map(s => `<option value="${s.id}">${s.name}</option>`).join('');
                    } catch {
                        stateSelect.innerHTML = '<option value="">Failed to load</option>';
                    }

                    // Fetch Cities
                    try {
                        const res = await fetch(`${BASE_URL}/cities`, {
                            headers: {
                                Authorization: `Bearer ${authToken}`,
                                Accept: 'application/json'
                            },
                        });
                        citiesAll = (await res.json()).data || [];
                    } catch {
                        console.error("Cities failed");
                    }

                    // Handle Industry → Sub-Industry linkage
                    industrySelect.addEventListener('change', function () {
                        const selectedId = this.value;
                        const filtered = subIndustriesAll.filter(si => si.slug.startsWith(`${selectedId}_`));
                        subIndustrySelect.disabled = filtered.length === 0;
                        subIndustrySelect.innerHTML = '<option value="">Select Sub-Industry</option>' +
                            filtered.map(si => `<option value="${si.id}">${si.name}</option>`).join('');
                    });

                    // Handle State → City linkage
                    stateSelect.addEventListener('change', function () {
                        const selectedStateId = parseInt(this.value);
                        const selectedStateName = this.options[this.selectedIndex].text;
                        const filteredCities = citiesAll.filter(c => c.state_name === selectedStateName);
                        citySelect.disabled = filteredCities.length === 0;
                        citySelect.innerHTML = '<option value="">Select City</option>' +
                            filteredCities.map(c => `<option value="${c.name}">${c.name}</option>`).join('');
                    });
                },
                // preConfirm: async () => {
                //     const form = document.getElementById('addProductForm');
                //     const formData = new FormData(form);

                //     const body = {
                //         product_name: formData.get('product_name'),
                //         original_price: parseFloat(formData.get('original_price')),
                //         selling_price: parseFloat(formData.get('selling_price')),
                //         offer_quantity: parseInt(formData.get('offer_quantity')),
                //         minimum_quantity: parseInt(formData.get('minimum_quantity')),
                //         unit: formData.get('unit'),
                //         industry: parseInt(formData.get('industry')),
                //         sub_industry: parseInt(formData.get('sub_industry')),
                //         state_id: parseInt(formData.get('state_id')),
                //         city: formData.get('city'),
                //         description: formData.get('description'),
                //         dimensions: formData.get('dimensions')
                //     };

                //     try {
                //         const response = await fetch(`${BASE_URL}/product`, {
                //             method: "POST",
                //             headers: {
                //                 Authorization: `Bearer ${authToken}`,
                //                 Accept: 'application/json'
                //             },
                //             body: JSON.stringify(body)
                //         });

                //         const res = await response.json();
                //         if (!res.success) throw new Error(res.message);
                //         return res;
                //     } catch (error) {
                //         Swal.showValidationMessage(`Failed: ${error.message}`);
                //     }
                // }
                preConfirm: async () => {
                    const getVal = (name) => document.querySelector(`[name="${name}"]`)?.value?.trim() || "";

                    const body = {
                        product_name: getVal("product_name"),
                        original_price: parseFloat(getVal("original_price")),
                        selling_price: parseFloat(getVal("selling_price")),
                        offer_quantity: parseInt(getVal("offer_quantity")),
                        minimum_quantity: parseInt(getVal("minimum_quantity")),
                        unit: getVal("unit"),
                        industry: parseInt(getVal("industry")),
                        sub_industry: parseInt(getVal("sub_industry")),
                        state_id: parseInt(getVal("state_id")),
                        city: getVal("city"),
                        description: getVal("description"),
                        dimensions: getVal("dimensions")
                    };

                    // basic validation
                    if (!body.product_name) {
                        Swal.showValidationMessage("Product Name is required");
                        return false;
                    }

                    try {
                        const response = await fetch(`${BASE_URL}/product`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: `Bearer ${authToken}`,
                                Accept: "application/json"
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
                    Swal.fire('Success!', result.value.message, 'success').then(() => {
                        window.location.href = 'pages/account.php';
                    });
                }
            });

        });
    });
</script> -->

<!-- <script>
    const BASE_URL = "https://api.stockoutindia.com/api";
    const authToken = localStorage.getItem("authToken");

    const headers = {
        "Content-Type": "application/json"
    };
    if (authToken) headers["Authorization"] = `Bearer ${authToken}`;

    // Load industry dropdown
    // fetch(`${BASE_URL}/industry`, { method: "GET", headers })
    //     .then(res => res.json())
    //     .then(result => {
    //         if (result.success) {
    //             const industrySelect = document.getElementById("industry");
    //             result.data.forEach(item => {
    //                 const opt = document.createElement("option");
    //                 opt.value = item.id;
    //                 opt.textContent = item.name;
    //                 industrySelect.appendChild(opt);
    //             });
    //         }
    //     });

    // Live search logic
    let typingTimer;
    document.getElementById("q").addEventListener("input", function () {
        const query = this.value.trim();
        const resultBox = document.getElementById("liveResults");
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
                            const html = result.data.slice(0, 5).map(product => `
                                <div class="bar_result border-bottom">
                                <a href="pages/product_detail.php?id=${encodeURIComponent(product.id)}" class="text-dark d-block">
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

    // Hide suggestions on outside click
    document.addEventListener("click", (e) => {
        if (!document.getElementById("searchForm").contains(e.target)) {
            document.getElementById("liveResults").style.display = "none";
        }
    });
</script> -->
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
                                    <a href="pages/product_detail.php?id=${encodeURIComponent(product.id)}" class="text-dark d-block">
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
                    window.location.href = `pages/product_detail.php?id=${productId}`;
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

