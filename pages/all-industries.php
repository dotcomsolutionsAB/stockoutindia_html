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
                    <div class="col-lg-12">
                        <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                            <!-- Filter and sorting options here -->
                        </nav>

                        <!-- Industries Grid -->
                        <div class="row Subindustries-body" id="industryGrid">
                            <!-- Industries showing here -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
<!-- End Home Pages -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const industryGrid = document.getElementById("industryGrid");
        let industryData = [];

        // Load industries
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
                    }
                })
                .catch(err => {
                    console.error("Error loading industries:", err);
                });
        }

        function renderIndustries(data) {
            industryGrid.innerHTML = ""; // Clear previous industries from grid

            // Loop through each industry and create a card
            data.forEach((ind, index) => {
                const col = document.createElement("div");
                col.className = "col-6 col-sm-4 col-md-3 col-lg-2"; // Adjust grid for 5 items per row (large screen)

                col.innerHTML = `
                    <div class="industry-card">
                        <a href="pages/filter-products?sub_industry=${ind.id}" class="industry-card-link">
                            <figure>
                                <img src="${ind.industry_image || 'uploads/placeholder.png'}" alt="${ind.name}" class="industry-card-image">
                            </figure>
                            <div class="industry-card-details">
                                <h3 class="industry-card-title">${ind.name}</h3>
                            </div>
                        </a>
                    </div>
                `;

                industryGrid.appendChild(col);
            });
        }
    });
</script>
<!-- <script>
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
</script> -->

<?php include("../footer.php") ?>