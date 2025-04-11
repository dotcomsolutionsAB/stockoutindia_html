<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 
<?php include("../configs/auth_check.php"); ?>

<!-- All products Pages -->
        <main class="main">

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

                                <div class="toolbox-item toolbox-sort">
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
                                    </div><!-- End .select-custom -->


                                </div><!-- End .toolbox-item -->
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-right">
                                <div class="toolbox-item toolbox-show">
                                    <label>Show:</label>

                                    <div class="select-custom">
                                        <select name="count" class="form-control">
                                            <option value="12">12</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .toolbox-item -->

                                <div class="toolbox-item layout-modes">
                                    <a href="category.html" class="layout-btn btn-grid active" title="Grid">
                                        <i class="icon-mode-grid"></i>
                                    </a>
                                    <a href="category-list.html" class="layout-btn btn-list" title="List">
                                        <i class="icon-mode-list"></i>
                                    </a>
                                </div><!-- End .layout-modes -->
                            </div><!-- End .toolbox-right -->
                        </nav>

                        <div class="row">
                           
                        </div><!-- End .row -->

                        <nav class="toolbox toolbox-pagination mb-0">
                            <div class="toolbox-item toolbox-show">
                                <label class="mt-0">Show:</label>

                                <div class="select-custom">
                                    <select name="count" class="form-control">
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                    </select>
                                </div><!-- End .select-custom -->
                            </div><!-- End .toolbox-item -->

                            <ul class="pagination toolbox-item">
                                <li class="page-item disabled">
                                    <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item">
                                    <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div><!-- End .col-lg-9 -->

                    <div class="sidebar-overlay"></div>
                    <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                        <div class="sidebar-wrapper">
                           <!-- FILTER SIDEBAR -->
                            <div class="widget">
                                <h3 class="widget-title">Industries</h3>
                                <input type="text" class="form-control mb-2" placeholder="Search industries..." onkeyup="filterList('industry')">
                                <div class="mb-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="selectAll('industry')">Select All</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="clearAll('industry')">Clear</button>
                                </div>
                                <div class="widget-body" id="industry-list" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title">Sub Industries</h3>
                                <input type="text" class="form-control mb-2" placeholder="Search sub-industries..." onkeyup="filterList('sub_industry')">
                                <div class="mb-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="selectAll('sub_industry')">Select All</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="clearAll('sub_industry')">Clear</button>
                                </div>
                                <div class="widget-body" id="sub_industry-list" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title">States</h3>
                                <input type="text" class="form-control mb-2" placeholder="Search states..." onkeyup="filterList('state')">
                                <div class="mb-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="selectAll('state')">Select All</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="clearAll('state')">Clear</button>
                                </div>
                                <div class="widget-body" id="state-list" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>

                            <div class="widget">
                                <h3 class="widget-title">Cities</h3>
                                <input type="text" class="form-control mb-2" placeholder="Search cities..." onkeyup="filterList('city')">
                                <div class="mb-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="selectAll('city')">Select All</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="clearAll('city')">Clear</button>
                                </div>
                                <div class="widget-body" id="city-list" style="max-height: 200px; overflow-y: auto;"></div>
                            </div>

                            <div class="widget text-center">
                                <button class="btn btn-danger btn-sm me-2" onclick="resetFilters()">Reset Filters</button>
                                <button class="btn btn-success btn-sm" onclick="applyFilters()">Apply Filters</button>
                            </div>

                        </div><!-- End .sidebar-wrapper -->
                    </aside>
                </div>
            </div>
        </main><!-- End .main -->
<!-- End All products Pages -->
<script>
    const BASE = "<?php echo BASE_URL; ?>";
    document.addEventListener('DOMContentLoaded', () => {
        fetchFilters();
        fetchProducts();
    });

    function fetchFilters() {
        fetch(`${BASE}/industry`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const data = Array.isArray(res.data) ? res.data : [res.data];
                    const container = document.getElementById('industry-list');
                    container.innerHTML = '';
                    data.forEach(ind => {
                        container.innerHTML += `<label><input type="checkbox" name="industry[]" value="${ind.id}"> ${ind.name}</label>`;
                    });
                }
            });

        fetch(`${BASE}/sub_industry`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const container = document.getElementById('sub_industry-list');
                    container.innerHTML = '';
                    res.data.forEach(sub => {
                        container.innerHTML += `<label><input type="checkbox" name="sub_industry[]" value="${sub.id}"> ${sub.name}</label>`;
                    });
                }
            });

        fetch(`${BASE}/states`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const container = document.getElementById('state-list');
                    container.innerHTML = '';
                    res.data.forEach(state => {
                        container.innerHTML += `<label><input type="checkbox" name="state[]" value="${state.id}"> ${state.name}</label>`;
                    });
                }
            });

        fetch(`${BASE}/cities`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const container = document.getElementById('city-list');
                    container.innerHTML = '';
                    res.data.forEach(city => {
                        container.innerHTML += `<label><input type="checkbox" name="city[]" value="${city.name}"> ${city.name}</label>`;
                    });
                }
            });
    }
</script>

<script>
    let filters = {
        industry: [],
        sub_industry: [],
        state: [],
        city: []
    };
    let limit = 12;
    let offset = 0;

    function getSelected(name) {
        return Array.from(document.querySelectorAll(`input[name="${name}[]"]:checked`)).map(el => el.value);
    }

    function applyFilters() {
        const payload = {
            industry: getSelected('industry').join(','),
            sub_industry: getSelected('sub_industry').join(','),
            state_id: getSelected('state').join(','),
            city: getSelected('city').join(','),
            limit: limit,
            offset: offset
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
                renderProducts(res.data);
            }
        })
        .catch(err => console.error("Fetch error", err));
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

    function fetchProducts() {
        const payload = {
            industry: filters.industry.join(","),
            sub_industry: filters.sub_industry.join(","),
            state_id: filters.state.join(","),
            city: filters.city.join(","),
            limit: limit,
            offset: offset
        };

        const token = localStorage.getItem('authToken');
        fetch(`<?php echo BASE_URL; ?>/product/get_products`, {
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
                renderProducts(res.data);
            }
        }).catch(err => console.log("Product Fetch Error", err));
    }

    function renderProducts(products) {
        const container = document.querySelector('.row.main-content .row');
        container.innerHTML = ''; // clear old products

        products.forEach(product => {
            const image = product.image?.[0] || 'default.jpg';
            const html = `
            <div class="col-12 col-sm-6 col-md-3 d-flex justify-content-center">
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
                        <button class="btn btn-success w-50 rounded-0 rounded-bottom-start"><i class="fa-brands fa-whatsapp"></i></button>
                        <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end"><i class="fa-solid fa-phone"></i></button>
                    </div>
                </div>
            </div>`;
            container.innerHTML += html;
        });
    }

    // Call once on page load
    document.addEventListener('DOMContentLoaded', fetchProducts);
</script>


<?php include("../footer.php") ?>