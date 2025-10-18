<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main global_page ">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Filter Products</a></li>
            </ol>
        </div>
    </nav>

    <div class="container">
        <section class="filter_products" id="filter_products">
            <h3 id="industry-name" class="text-center my-4 fw-bold text-dark"></h3>
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
        // ✅ Add this line
        const isGuest = !authToken;  // true when user is not logged in

        const urlParams = new URLSearchParams(window.location.search);
        const IndustryId = urlParams.get("industry");
        // const isDisabled = !authToken;

        if (!IndustryId) return;

        const endpoint = authToken
            ? `${BASE_URL}/product/get_products`
            : `${BASE_URL}/get_products`;

            fetch(endpoint, {
                method: "POST",
                headers,
                body: JSON.stringify({ industry: IndustryId })
            })
            .then(res => res.json())
            .then(result => {
                const nameHeading = document.getElementById("industry-name");
                const productContainer = document.getElementById("product-list");

                if (result.success && result.data.length > 0) {
                    // ✅ Show sub-industry name
                    const IndustryName = result.data[0].industry_details?.name || "";
                    nameHeading.textContent = IndustryName;

                    productContainer.innerHTML = "";

                    result.data.forEach(product => {
                        const productLink = `pages/product_detail?id=${product.id}`;
                        const image = product.image?.[0] || "uploads/placeholder.png";
                        /* phone can be phone or mobile; strip the leading “+” */
                        const rawPhone  = product.user?.phone || product.user?.mobile || '';
                        const phone     = rawPhone.trim();                       // KEEP the “+”
                        const waPhone   = phone.replace(/^\+/, '');              // remove “+” only for WA
                        const hasPhone  = waPhone !== '';  

                        const cardHtml = `
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
                            </div>
                        `;

                        productContainer.insertAdjacentHTML("beforeend", cardHtml);
                    });
                } else {
                    document.getElementById("product-list").innerHTML = `
                        <div class="col-12 text-center py-4 text-muted">
                            No products found in this Industry.
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

    // for wishlist and share
    document.addEventListener("click", async (e) => {
        const authToken = localStorage.getItem("authToken");
        const userId = localStorage.getItem("user_id");

        // ❤️ Wishlist Button
        if (e.target.matches(".fa-heart")) {
            const card = e.target.closest(".product-card");
            const productId = card?.querySelector("a.updateProductBtn")?.dataset?.id || card?.querySelector("a")?.href?.split("id=")[1];

            if (!authToken || !userId || !productId) {
            Swal.fire("Unauthorized", "Please log in to use wishlist.", "warning");
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
</script>

<?php include("../footer.php") ?>