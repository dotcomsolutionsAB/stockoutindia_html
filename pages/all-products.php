<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>
    <!-- All products Pages -->
        <main class="main products_page global_page">

            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </nav>

            <div class="container">
                <div class="row main-content">
                    <div class="col-lg-12">
                        <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                            <div class="toolbox-left">
                                <a href="#" class="sidebar-toggle"><svg data-name="Layer 3" id="Layer_3"
                                        viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                        <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                        <path
                                            d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                        <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2">
                                        </path>
                                        <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                        <path
                                            d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                    </svg>
                                    <span>Filter</span>
                                </a>
                            </div>
                        </nav>
                        <div class="row" id="product-list"></div>
                        <!-- HTML Section -->
                        <nav class="toolbox toolbox-pagination mb-0 d-flex justify-content-between align-items-center flex-wrap">
                            <div class="toolbox-item toolbox-show d-flex align-items-center gap-2">
                                <label class="mt-0">Show:</label>
                                <div class="select-custom">
                                <select id="product-count" class="form-control">
                                    <option value="12">12</option>
                                    <option value="20">20</option>
                                    <option value="28">28</option>
                                    <option value="56">56</option>
                                </select>

                                </div>
                            </div>
                            <ul class="pagination toolbox-item d-flex flex-wrap" style="margin: 0;"></ul>
                        </nav>

                    </div><!-- End .col-lg-9 -->

                    <div class="sidebar-overlay"></div>
                    <!-- <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                        <div class="sidebar-wrapper">
                            
                            <div class="widget">
                                <h3 class="widget-title">States</h3>
                                <input type="text" class="form-control mb-2" placeholder="Search states..." onkeyup="filterList('state', event)">

                                <div class="mb-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="selectAll('state')">Select All</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="clearAll('state')">Clear</button>
                                </div>
                                <div class="widget-body" id="state-list" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                        </div>
                    </aside> -->
                </div>
            </div>
        </main>
    <!-- End All products Pages -->

<script>
    const BASE = "<?php echo BASE_URL; ?>";
    let limit = 12;
    let offset = 0;
    let total = 0;

    document.addEventListener('DOMContentLoaded', () => {
        // fetchFilters();
        fetchProducts();
        setupEvents();
    });

    // function fetchFilters() {
    //     fetch(`${BASE}/states`)
    //         .then(res => res.json())
    //         .then(res => {
    //             if (res.success) {
    //                 const container = document.getElementById('state-list');
    //                 container.innerHTML = '';
    //                 res.data.forEach(state => {
    //                     container.innerHTML += `<label class="d-block"><input type="checkbox" name="state[]" value="${state.id}" onchange="fetchProducts()"> ${state.name}</label>`;
    //                 });
    //             }
    //         });
    // }

    function getSelected(name) {
        return Array.from(document.querySelectorAll(`input[name="${name}[]"]:checked`)).map(el => el.value);
    }

    function fetchProducts() {
        const token = localStorage.getItem("authToken");
        const endpoint = token
            ? `${BASE}/product/get_products`
            : `${BASE}/get_products`;

        const payload = {
            state_id: getSelected('state').join(','),  // Use your selection helper
            limit: limit,
            offset: offset
        };

        console.log("Sent Payload:", payload);

        fetch(endpoint, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                ...(token && { "Authorization": `Bearer ${token}` })
            },
            body: JSON.stringify(payload)
        })
            .then(res => res.json())
            .then(res => {
                console.log("API Response:", res);
                if (res.success) {
                    renderProducts(res.data || []);
                    total = res.total_record || 0;
                    renderPagination();
                } else {
                    alert("Failed to fetch products.");
                }
            })
            .catch(err => console.error("Fetch error", err));
    }

    function renderProducts(products) {
        const container = document.getElementById('product-list');
        container.innerHTML = '';

        /* global authToken already exists elsewhere in your code */
        const isGuest = !authToken;          // true → user not logged in

        if (!products.length) {
            container.innerHTML = `<div class="col-12 text-center py-4" style="min-height: 60vh; display: flex; justify-content: center;
            align-items: center; font-size: 30px;">No products found !</div>`;
            return;
        }

        products.forEach(product => {
            const image = product.image?.[0] || 'uploads/placeholder.png';
            const productLink = `pages/product_detail?id=${product.id}`;
            /* phone can be phone or mobile; strip the leading “+” */
            const rawPhone  = product.user?.phone || product.user?.mobile || '';
            const phone     = rawPhone.trim();                       // KEEP the “+”
            const waPhone   = phone.replace(/^\+/, '');              // remove “+” only for WA
            const hasPhone  = waPhone !== '';  

            container.innerHTML += `
                <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
                    <div class="product-card bg-white">
                        <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-4 card_side_icon">
                            <i class="fa-regular fa-heart text-danger" style="cursor: pointer;"></i>
                            <i class="fa-solid fa-share text-danger" style="cursor: pointer;"></i>
                        </div>
                        <div class="image_box">
                            <a href="${productLink}">
                                <img src="${image}" class="card-img-top img-fluid" alt="${product.product_name}">
                            </a>
                        </div>
                        <hr class="my-0">
                        <div class="card-body pt-2 pb-1 px-3"> 
                            <div class="upper_content">      
                                <div class="left_side_body">
                                    <a href="${productLink}">
                                        <h6 class="text-success fw-bold">
                                            ${product.product_name.length > 30 
                                                ? product.product_name.substring(0, 27) + '...' 
                                                : product.product_name}
                                        </h6>
                                    </a>
                                </div>
                                <div class="right_side_body">
                                    <span class="badge badge text-secondary">Qty: <strong>${product.offer_quantity}</strong></span>
                                    <span class="badge badge text-dark">Min: <strong>${product.minimum_quantity}</strong></span>
                                </div>
                            </div>  
                            <div class="lower_content">
                                <p class="p_user fw-semibold mb0">Dealer: 
                                    ${product.user?.name 
                                        ? (product.user.name.length > 15 
                                            ? product.user.name.substring(0, 12) + '...' 
                                            : product.user.name)
                                        : "N/A"}
                                </p>
                                <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">₹${product.selling_price}/${product.unit}</p>
                            </div>                          
                        </div>
                        <div class="d-flex bottom-btns global_page_card">
                            <button
                                class="btn btn-success w-50 rounded-0 rounded-bottom-start 
                                    ${(isGuest || !hasPhone) ? 'disabled-btn' : ''}"
                                ${(hasPhone) ? `onclick="handleWhatsApp('${waPhone}', ${isGuest})"` : ''}
                            >
                                <i class="fa-brands fa-whatsapp"></i>
                            </button>

                            <button
                                class="btn btn-danger  w-50 rounded-0 rounded-bottom-end 
                                    ${(isGuest || !hasPhone) ? 'disabled-btn' : ''}"
                                ${(hasPhone) ? `onclick="handleCall('${phone}', ${isGuest})"` : ''}
                            >
                                <i class="fa-solid fa-phone"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
        });
    }
    
    /* ==================================================================== */
    function handleWhatsApp(number, isDisabled) {
        /* isDisabled === true means guest user */
        if (isDisabled) return showLoginAlert();
        if (!number)     return;                         // safety-guard
        window.open(`https://wa.me/${number}?text=${encodeURIComponent('Hi')}`, '_blank');
    }

    /* ==================================================================== */
    function handleCall(number, isDisabled) {
        if (isDisabled) return showLoginAlert();
        if (!number)     return;
        window.location.href = `tel:${number}`;
    }

    // for wishlist and share
    document.addEventListener("click", async (e) => {
        const authToken = localStorage.getItem("authToken");
        const userId = localStorage.getItem("user_id");

        // ❤️ Wishlist Button
        if (e.target.matches(".fa-heart")) {
            const card = e.target.closest(".product-card");
            const productId = card?.querySelector("a.updateProductBtn")?.dataset?.id || card?.querySelector("a")?.href?.split("id=")[1];

            if (!authToken || !userId || !productId) {
            Swal.fire("Login First", "Please log in to use wishlist.", "warning");
            return;
            }

            try {
            const res = await fetch(`<?php echo BASE_URL; ?>/wishlist/add`, {
                method: "POST",
                headers: {
                "Authorization": `Bearer ${authToken}`,
                "Content-Type": "application/json"
                },
                body: JSON.stringify({
                user_id: parseInt(userId),
                product_id: parseInt(productId)
                })
            });

            const result = await res.json();

            if (result.success) {
                Toastify({
                text: "Added to wishlist ❤️",
                duration: 2000,
                gravity: "bottom",
                position: "right",
                backgroundColor: "#b30000"
                }).showToast();
            } else {
                Swal.fire("Error", result.message || "Could not add to wishlist", "error");
            }
            } catch (err) {
            Swal.fire("Error", "Request failed", "error");
            }
        }

        // 📤 Share Button
        if (e.target.matches(".fa-share")) {
            const card = e.target.closest(".product-card");
            const productId = card?.querySelector("a")?.href?.split("id=")[1];

            if (!productId) return;

            const shareUrl = `https://new.stockoutindia.com/pages/product_detail?id=${productId}`;

            try {
            await navigator.clipboard.writeText(shareUrl);
            Toastify({
                text: "Copied link to clipboard 🔗",
                duration: 2000,
                gravity: "bottom",
                position: "center",
                backgroundColor: "#28a745"
            }).showToast();
            } catch (err) {
            Swal.fire("Oops!", "Clipboard not supported!", "error");
            }
        }
    });
    // end wishlist and share

    function showLoginAlert() {
        Swal.fire({
            title: "Login Required",
            text: "You need to be logged user.",
            icon: "warning",
            confirmButtonText: "Login",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login"; // replace with your actual login page
            }
        });
    }

    function setupEvents() {
        const select = document.getElementById('product-count');

        if (select) {
            console.log("✅ Dropdown found by ID");
            select.value = limit;

            select.addEventListener('change', function (e) {
                limit = parseInt(this.value);
                offset = 0;
                console.log("✅ LIMIT CHANGED TO:", limit, "OFFSET:", offset);
                fetchProducts();
            });
        } else {
            console.error("❌ Dropdown with ID 'product-count' not found.");
        }
    }

    function renderPagination() {
        const totalPages = Math.ceil(total / limit);
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = '';

        const currentPage = Math.floor(offset / limit);

        // Previous Button
        const prevDisabled = currentPage === 0 ? 'disabled' : '';
        pagination.innerHTML += `
            <li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" onclick="event.preventDefault(); goToPage(${currentPage - 1})">Previous</a>
            </li>`;

        // Numbered Pages
        for (let i = 0; i < totalPages; i++) {
            const isActive = (i === currentPage) ? 'active' : '';
            pagination.innerHTML += `
                <li class="page-item ${isActive}">
                    <a class="page-link" href="#" onclick="event.preventDefault(); goToPage(${i})">${i + 1}</a>
                </li>`;
        }

        // Next Button
        const nextDisabled = currentPage >= totalPages - 1 ? 'disabled' : '';
        pagination.innerHTML += `
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" onclick="event.preventDefault(); goToPage(${currentPage + 1})">Next</a>
            </li>`;
    }

    function goToPage(pageIndex) {
        offset = pageIndex * limit;
        fetchProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function filterList(type, event) {
        const input = event.target.value.toLowerCase();
        const items = document.querySelectorAll(`#${type}-list label`);
        
        items.forEach(label => {
            const stateName = label.textContent.trim().toLowerCase();
            if (stateName.includes(input)) {
                label.style.display = 'block';
            } else {
                label.style.display = 'none';
            }
        });
    }

    function selectAll(type) {
        document.querySelectorAll(`#${type}-list label`).forEach(label => {
            if (label.style.display !== 'none') {
                const checkbox = label.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.checked = true;
            }
        });
        fetchProducts(); // re-fetch based on new selections
    }

    function clearAll(type) {
        document.querySelectorAll(`#${type}-list label`).forEach(label => {
            if (label.style.display !== 'none') {
                const checkbox = label.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.checked = false;
            }
        });
        fetchProducts(); // re-fetch based on cleared selections
    }

</script>
<?php include("../footer.php") ?>