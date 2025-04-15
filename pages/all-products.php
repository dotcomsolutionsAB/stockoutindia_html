<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>
<!-- All products Pages -->
        <main class="main products_page global_page">

            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </nav>

            <div class="container">
                <div class="row main-content">
                    <div class="col-lg-9">
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
                                <!-- <div class="toolbox-item toolbox-sort">
                                    <label>Sort By:</label>
                                    <div class="select-custom">
                                        <select name="orderby" class="form-control">
                                            <option value="menu_order" selected="selected">Default sorting</option>
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="rating">Sort by average rating</option>
                                            <option value="date">Sort by newness</option>
                                            <option value="price">Sort by price: low to high</option>
                                            <option value="price-desc">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div> -->
                            </div><!-- End .toolbox-left -->

                            <!-- <div class="toolbox-right">
                                <div class="toolbox-item toolbox-show">
                                    <label>Show:</label>

                                    <div class="select-custom">
                                        <select name="count" class="form-control">
                                            <option value="12">12</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="toolbox-item layout-modes">
                                    <a href="category.html" class="layout-btn btn-grid active" title="Grid">
                                        <i class="icon-mode-grid"></i>
                                    </a>
                                    <a href="category-list.html" class="layout-btn btn-list" title="List">
                                        <i class="icon-mode-list"></i>
                                    </a>
                                </div>
                            </div> -->
                        </nav>
                        <!-- <div class="row" id="product-list">
                            <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
                                <div class="product-card bg-white">
                                    <span class="badge bg-danger text-white position-absolute top-0 start-0 mt-1 m-2 px-2 py-2 rounded-pill badge-featured">Featured</span>
                                    <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-4 card_side_icon">
                                        <i class="fa-regular fa-heart text-danger" style="cursor: pointer;"></i>
                                        <i class="fa-solid fa-share text-danger" style="cursor: pointer;"></i>
                                    </div>
                                    <div class="image_box">
                                        <img src="${image}" class="card-img-top img-fluid" alt="${product.product_name}">
                                    </div>
                                    <hr class="my-0">
                                    <div class="card-body pt-2 pb-1 px-3">                
                                        <div class="left_side_body">
                                            <h6 class="text-success fw-bold">${product.product_name}</h6>
                                            <p class="p_user fw-semibold mb0">Dealer: ${product.user?.name || "N/A"}</p>
                                            <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">₹${product.selling_price}/${product.unit}</p>
                                        </div>
                                        <div class="right_side_body">
                                            <span class="badge bg-secondary text-white">Qty: <strong>${product.offer_quantity}</strong></span>
                                            <span class="badge bg-warning text-dark">Min: <strong>${product.minimum_quantity}</strong></span>
                                        </div>
                                    </div>
                                    <div class="d-flex bottom-btns index_page_card">
                                        <button class="btn btn-success w-50 rounded-0 rounded-bottom-start">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </button>
                                        <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end">
                                            <i class="fa-solid fa-phone"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

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
                    <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                        <div class="sidebar-wrapper">
                           <!-- FILTER SIDEBAR -->
                            
                            <div class="widget">
                                <h3 class="widget-title">States</h3>
                                <input type="text" class="form-control mb-2" placeholder="Search states..." onkeyup="filterList('state')">
                                <div class="mb-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="selectAll('state')">Select All</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="clearAll('state')">Clear</button>
                                </div>
                                <div class="widget-body" id="state-list" style="max-height: 300px; overflow-y: auto;"></div>
                            </div>

                        </div><!-- End .sidebar-wrapper -->
                    </aside>
                </div>
            </div>
        </main><!-- End .main -->
<!-- End All products Pages -->

<script>
    const BASE = "<?php echo BASE_URL; ?>";
    let limit = 12;
    let offset = 0;
    let total = 0;

    document.addEventListener('DOMContentLoaded', () => {
        fetchFilters();
        fetchProducts();
        setupEvents();
    });

    function fetchFilters() {
        fetch(`${BASE}/states`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const container = document.getElementById('state-list');
                    container.innerHTML = '';
                    res.data.forEach(state => {
                        container.innerHTML += `<label class="d-block"><input type="checkbox" name="state[]" value="${state.id}" onchange="fetchProducts()"> ${state.name}</label>`;
                    });
                }
            });
    }

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

        const isDisabled = !authToken;

        if (!products.length) {
            container.innerHTML = `<div class="col-12 text-center py-4">No products found.</div>`;
            return;
        }

        products.forEach(product => {
            const image = product.image?.[0] || 'uploads/placeholder.png';
            const productLink = `pages/product_detail.php?id=${product.id}`;
            const phone = product.user?.mobile || '';
            const whatsapp = product.user?.whatsapp || phone;

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
                            <button class="btn btn-success w-50 rounded-0 rounded-bottom-start ${!authToken ? 'disabled-btn' : ''}" 
                                onclick="handleWhatsApp('${whatsapp}', ${!authToken})">
                                <i class="fa-brands fa-whatsapp"></i>
                            </button>
                            <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end ${!authToken ? 'disabled-btn' : ''}" 
                                onclick="handleCall('${phone}', ${!authToken})">
                                <i class="fa-solid fa-phone"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
        });
    }

    function handleWhatsApp(_, isDisabled) {
        if (isDisabled) return showLoginAlert();

        const staticNumber = "917019616007"; // no '+' in wa.me links
        const message = "Hi";
        window.open(`https://wa.me/${staticNumber}?text=${encodeURIComponent(message)}`, '_blank');
    }

    function handleCall(_, isDisabled) {
        if (isDisabled) return showLoginAlert();

        const staticNumber = "+918597148785";
        window.location.href = `tel:${staticNumber}`;
    }

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
                window.location.href = "login.php"; // replace with your actual login page
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
</script>

<!-- <script>
    const BASE = "<?php echo BASE_URL; ?>";
    let filters = {
        industry: [],
        sub_industry: [],
        state: [],
        city: []
    };
    let limit = 12;
    let offset = 0;
    let totalRecord = 0;

    // INIT
    document.addEventListener('DOMContentLoaded', () => {
        // After filters load:
        fetchIndustries()
            .then(fetchSubIndustries)
            .then(fetchStates)
            .then(fetchCities)
            .then(fetchProducts);

        // 👇 Add this inside DOMContentLoaded to listen to dropdown
        const countSelect = document.querySelector("select[name='count']");
        if (countSelect) {
            countSelect.addEventListener("change", (e) => {
                limit = parseInt(e.target.value);
                offset = 0;
                fetchProducts();
            });
        }
    });


    // FILTER LOADERS STEP BY STEP
    async function fetchIndustries() {
        const res = await fetch(`${BASE}/industry`);
        const json = await res.json();
        if (json.success) {
            const data = Array.isArray(json.data) ? json.data : [json.data];
            const container = document.getElementById('industry-list');
            container.innerHTML = '';
            data.forEach(ind => {
                container.innerHTML += `<label><input type="checkbox" name="industry[]" value="${ind.id}"> ${ind.name}</label>`;
            });
        }
    }

    async function fetchSubIndustries() {
        const res = await fetch(`${BASE}/sub_industry`);
        const json = await res.json();
        if (json.success) {
            const container = document.getElementById('sub_industry-list');
            container.innerHTML = '';
            json.data.forEach(sub => {
                container.innerHTML += `<label><input type="checkbox" name="sub_industry[]" value="${sub.id}"> ${sub.name}</label>`;
            });
        }
    }

    async function fetchStates() {
        const res = await fetch(`${BASE}/states`);
        const json = await res.json();
        if (json.success) {
            const container = document.getElementById('state-list');
            container.innerHTML = '';
            json.data.forEach(state => {
                container.innerHTML += `<label><input type="checkbox" name="state[]" value="${state.id}"> ${state.name}</label>`;
            });
        }
    }

    async function fetchCities() {
        const res = await fetch(`${BASE}/cities`);
        const json = await res.json();
        if (json.success) {
            const container = document.getElementById('city-list');
            container.innerHTML = '';
            json.data.forEach(city => {
                container.innerHTML += `<label><input type="checkbox" name="city[]" value="${city.name}"> ${city.name}</label>`;
            });
        }
    }

    // MAIN PRODUCT FETCH
    function fetchProducts() {
        showSkeletonLoader();
        const payload = {
            industry: filters.industry.join(","),
            sub_industry: filters.sub_industry.join(","),
            state_id: filters.state.join(","),
            city: filters.city.join(","),
            limit,
            offset
        };

        const token = localStorage.getItem('authToken');
        fetch(`${BASE}/product/get_products`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...(token && { 'Authorization': `Bearer ${token}` })
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                totalRecord = res.total_record || 0;
                renderProducts(res.data);
                renderPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        })
        .catch(err => console.log("Product Fetch Error", err));
    }

    function showSkeletonLoader() {
        const container = document.querySelector('.row.main-content .row');
        container.innerHTML = '';
        for (let i = 0; i < limit; i++) {
            container.innerHTML += `
                <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
                    <div class="product-card bg-white p-3 placeholder-glow" style="width: 100%; min-height: 350px;">
                        <div class="placeholder w-100" style="height: 200px;"></div>
                        <div class="mt-2">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                        </div>
                    </div>
                </div>`;
        }
    }

    function renderProducts(products) {
        const container = document.querySelector('.row.main-content .row');
        container.innerHTML = '';

        products.forEach(product => {
            const image = product.image?.[0] || '../uploads/placeholder.png';
            container.innerHTML += `
            <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
                <div class="product-card bg-white">
                    <span class="badge bg-danger text-white position-absolute top-0 start-0 mt-1 m-2 px-2 py-2 rounded-pill badge-featured">Featured</span>
                    <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-4 card_side_icon">
                        <i class="fa-regular fa-heart text-danger" style="cursor: pointer;"></i>
                        <i class="fa-solid fa-share text-danger" style="cursor: pointer;"></i>
                    </div>
                    <div class="image_box">
                        <img loading="lazy" src="${image}" class="card-img-top img-fluid" alt="${product.product_name}">
                    </div>
                    <hr class="my-0">
                    <div class="card-body pt-2 pb-1 px-3">
                        <div class="left_side_body">
                            <h6 class="text-success fw-bold">${product.product_name}</h6>
                            <p class="p_user fw-semibold mb0">Dealer: ${product.user?.name || "N/A"}</p>
                            <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">₹${product.selling_price}/${product.unit}</p>
                        </div>
                        <div class="right_side_body">
                            <span class="badge bg-secondary text-white">Qty: <strong>${product.offer_quantity}</strong></span>
                            <span class="badge bg-warning text-dark">Min: <strong>${product.minimum_quantity}</strong></span>
                        </div>
                    </div>
                    <div class="d-flex bottom-btns index_page_card">
                        <button class="btn btn-success w-50 rounded-0 rounded-bottom-start"><i class="fa-brands fa-whatsapp"></i></button>
                        <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end"><i class="fa-solid fa-phone"></i></button>
                    </div>
                </div>
            </div>`;
        });
    }

    function renderPagination() {
        const totalPages = Math.ceil(totalRecord / limit);
        const currentPage = offset / limit + 1;
        let paginationHTML = '';

        if (totalPages <= 1) {
            document.querySelector('.pagination.toolbox-item').innerHTML = '';
            return;
        }

        paginationHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link page-link-btn" href="#" onclick="goToPage(${currentPage - 1})"><i class="icon-angle-left"></i></a>
        </li>`;

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
            </li>`;
        }

        paginationHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link page-link-btn" href="#" onclick="goToPage(${currentPage + 1})"><i class="icon-angle-right"></i></a>
        </li>`;

        document.querySelector('.pagination.toolbox-item').innerHTML = paginationHTML;
    }
    function goToPage(page) {
        const totalPages = Math.ceil(totalRecord / limit);
        if (page < 1 || page > totalPages) return;
        offset = (page - 1) * limit;
        fetchProducts();
    }

    function getSelected(name) {
        return Array.from(document.querySelectorAll(`input[name="${name}[]"]:checked`)).map(el => el.value);
    }

    function applyFilters() {
        filters.industry = getSelected('industry');
        filters.sub_industry = getSelected('sub_industry');
        filters.state = getSelected('state');
        filters.city = getSelected('city');
        offset = 0;
        fetchProducts();
    }

    function resetFilters() {
        filters = { industry: [], sub_industry: [], state: [], city: [] };
        document.querySelectorAll('.widget-body input[type="checkbox"]').forEach(c => c.checked = false);
        offset = 0;
        fetchProducts();
    }

    function selectAll(type) {
        document.querySelectorAll(`#${type}-list input[type="checkbox"]`).forEach(c => c.checked = true);
    }

    function clearAll(type) {
        document.querySelectorAll(`#${type}-list input[type="checkbox"]`).forEach(c => c.checked = false);
    }

    function filterList(type) {
        const input = event.target.value.toLowerCase();
        const items = document.querySelectorAll(`#${type}-list label`);
        items.forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(input) ? 'block' : 'none';
        });
    }
</script> -->
<?php include("../footer.php") ?>