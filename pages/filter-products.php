<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main global_page ">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Filter Products</a></li>
            </ol>
        </div>
    </nav>

    <div class="container">
        <section class="filter_products" id="filter_products">
            <h3 id="sub-industry-name" class="text-center my-4 fw-bold text-dark"></h3>
            <div class="row" id="product-list">
                <!-- Dynamic product cards will appear here -->
            </div>
        </section>
    </div><!-- End .container -->
</main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const BASE_URL = "https://api.stockoutindia.com/api";
        const authToken = localStorage.getItem("authToken");
        const headers = { "Content-Type": "application/json" };
        if (authToken) headers["Authorization"] = `Bearer ${authToken}`;

        const urlParams = new URLSearchParams(window.location.search);
        const subIndustryId = urlParams.get("sub_industry");
        const isDisabled = !authToken;

        if (!subIndustryId) return;

        const endpoint = authToken
            ? `${BASE_URL}/product/get_products`
            : `${BASE_URL}/get_products`;

            fetch(endpoint, {
                method: "POST",
                headers,
                body: JSON.stringify({ sub_industry: subIndustryId })
            })
            .then(res => res.json())
            .then(result => {
                const nameHeading = document.getElementById("sub-industry-name");
                const productContainer = document.getElementById("product-list");

                if (result.success && result.data.length > 0) {
                    // ✅ Show sub-industry name
                    const subIndustryName = result.data[0].sub_industry_details?.name || "";
                    nameHeading.textContent = subIndustryName;

                    productContainer.innerHTML = "";

                    result.data.forEach(product => {
                        const productLink = `pages/product_detail.php?id=${product.id}`;
                        const image = product.image?.[0] || "uploads/placeholder.png";
                        const whatsapp = product.user?.mobile || "";
                        const phone = product.user?.mobile || "";

                        const cardHtml = `
                            <div class="col-12 col-sm-6 col-md-3 d-flex justify-content-center">
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
                            </div>
                        `;

                        productContainer.insertAdjacentHTML("beforeend", cardHtml);
                    });
                } else {
                    document.getElementById("product-list").innerHTML = `
                        <div class="col-12 text-center py-4 text-muted">
                            No products found in this sub-industry.
                        </div>`;
                }
            })
            .catch(err => {
                console.error("API error:", err);
                document.getElementById("product-list").innerHTML = `
                    <div class="col-12 text-center py-4 text-danger">
                        Error fetching products. Please try again later.
                    </div>`;
            });
    });

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
</script>

<?php include("../footer.php") ?>