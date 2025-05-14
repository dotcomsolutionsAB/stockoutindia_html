<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 

<!-- Industries Pages -->
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Industries</li>
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

                        <div class="row Subindustries-body" id="subIndustryGrid">
                            <!-- Subindustries Showing -->
                        </div>

                        <!-- <nav class="toolbox toolbox-pagination mb-0">
                            <div class="toolbox-item toolbox-show">
                                <label class="mt-0">Show:</label>

                                <div class="select-custom">
                                    <select name="count" class="form-control">
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                    </select>
                                </div>
                            </div>

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
                        </nav> -->
                    </div><!-- End .col-lg-9 -->

                    <div class="sidebar-overlay"></div>
                    <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                        <div class="sidebar-wrapper">
                            <ul class="cat-list-industry" id="industryList"></ul>                            
                        </div><!-- End .sidebar-wrapper -->
                    </aside>
                </div><!-- End .row -->
            </div><!-- End .container -->
        </main><!-- End .main -->
<!-- End Home Pages -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const industryListEl = document.getElementById("industryList");
        const subIndustryGrid = document.getElementById("subIndustryGrid");
        let industryData = [];

        // Load data
        fetchIndustries();

        function fetchIndustries() {
            const headers = {};
            const authToken = localStorage.getItem("authToken");
            if (authToken) {
                headers["Authorization"] = "Bearer " + authToken;
            }

            fetch("<?php echo BASE_URL; ?>/industry", { headers })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        industryData = res.data;
                        renderIndustries(industryData);
                        if (res.data.length > 0) {
                            renderSubIndustries(res.data[0].sub_industries);
                            highlightSelectedIndustry(res.data[0].id);
                        }
                    }
                })
                .catch(err => {
                    console.error("Error loading industries:", err);
                });
        }

        function renderIndustries(data) {
            industryListEl.innerHTML = "";
            data.forEach(ind => {
                const li = document.createElement("li");
                li.innerHTML = `
                    <a href="#" class="industry-link" data-id="${ind.id}">${ind.name}
                        <span class="products-count">(${ind.sub_industries.length})</span>
                    </a>
                `;
                industryListEl.appendChild(li);
            });

            // Click Events
            document.querySelectorAll(".industry-link").forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const industryId = +this.dataset.id;
                    const selectedIndustry = industryData.find(i => i.id === industryId);
                    if (selectedIndustry) {
                        renderSubIndustries(selectedIndustry.sub_industries);
                        highlightSelectedIndustry(industryId);
                    }
                });
            });
        }

        function highlightSelectedIndustry(id) {
            document.querySelectorAll(".industry-link").forEach(link => {
                link.classList.remove("active-industry");
            });
            const activeLink = document.querySelector(`.industry-link[data-id="${id}"]`);
            if (activeLink) activeLink.classList.add("active-industry");
        }

        function renderSubIndustries(subs) {
            subIndustryGrid.innerHTML = "";
            if (subs.length === 0) {
                subIndustryGrid.innerHTML = `<div class="col-12"><p>No sub-industries found.</p></div>`;
                return;
            }

            subs.forEach(sub => {
                const col = document.createElement("div");
                col.className = "col-6 col-sm-4 col-xl-3";

                // Check if product count is zero or less
                const isDisabled = sub.product_count <= 0 ? 'disabled-sub' : '';

                col.innerHTML = `
                    <div class="product-default left-details product-widget ${isDisabled}">
                        <figure>
                            <a href="${isDisabled ? 'javascript:void(0);' : `pages/filter-products?sub_industry=${sub.id}`}">
                                <img src="${sub.image || 'uploads/placeholder.png'}" width="75" height="75" alt="${sub.name}">
                            </a>
                        </figure>
                        <div class="product-details">
                            <h3 class="product-title">
                                <a href="${isDisabled ? 'javascript:void(0);' : `pages/filter-products?sub_industry=${sub.id}`}">${sub.name}</a>
                            </h3>                                                
                            <div class="price-box">
                                <span class="product-price"> ${sub.product_count} Product(s)</span>
                            </div>
                        </div>                        
                    </div>

                `;
                subIndustryGrid.appendChild(col);
            });
        }
    });
</script>

<?php include("../footer.php") ?>