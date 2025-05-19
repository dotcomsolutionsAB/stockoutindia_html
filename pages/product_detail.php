<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main global_page ">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
            </ol>
        </div>
    </nav>

    <div class="container">
        <section class="product_detail_section" id="product_detail_container">
            <!-- Content will be populated dynamically -->
        </section>
    </div><!-- End .container -->
    <section class="similar_product_section" id="similar_product_section">
        <h2 class="similar_title">Similar Products from this Seller</h2>
        <div class="row g-4" id="similar_product_grid">
            <!-- Product cards will appear here -->
        </div>
    </section>
</main>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    const authstoken = localStorage.getItem("authToken");

    if (!productId) {
        document.getElementById('product_detail_container').innerHTML = '<p style="padding:20px">Invalid product ID.</p>';
        throw new Error("No product ID provided.");
    }

    // Base URL depends on presence of authstoken
    const url = authstoken 
        ? `<?php echo BASE_URL; ?>/product/get_products/${productId}` 
        : `<?php echo BASE_URL; ?>/get_products/${productId}`;

    const headersObj  = {
        "Content-Type": "application/json"
    };
    if (authstoken) {
        headersObj["Authorization"] = `Bearer ${authstoken}`;
    }

    fetch(url, {
        method: "POST", // ✅ Use GET for fetching by ID
        headers: headersObj 
    })
    .then(res => res.json())
    .then(result => {
        if (result.success && result.data) {
            const matchedProduct = result.data;
            const industryId = matchedProduct.industry_details?.id;

            const html = `
                <div class="product_image_box">
                    <img src="${matchedProduct.image?.[0] || 'uploads/placeholder.png'}" alt="${matchedProduct.product_name}" class="product_image">
                </div>

                <div class="product_info">
                    <h2 class="product_title">${matchedProduct.product_name}</h2>
                    ${matchedProduct.original_price ? `<p class="product_price_old">₹ ${matchedProduct.original_price}/${matchedProduct.unit}</p>` : ''}
                    <p class="product_price_new">₹ ${matchedProduct.selling_price}/${matchedProduct.unit}</p>

                    <p class="product_min_order">Min Order: ${matchedProduct.minimum_quantity} ${matchedProduct.unit}</p>
                    ${matchedProduct.original_price ? `<p class="product_offer_highlight">${Math.round(((matchedProduct.original_price - matchedProduct.selling_price) / matchedProduct.original_price) * 100)}% Lower Than the Original Price</p>` : ''}
                    <p class="product_stock_status">${matchedProduct.status === 'sold' ? 'Sold Out' : 'Available in stock'}</p>
                    <p class="product_dealer_name">Dealer name: ${matchedProduct.user?.name || 'N/A'}</p>

                    <div class="product_icons">
                        ${
                            matchedProduct.user?.phone
                            ? authstoken
                                // Logged in: real WhatsApp link
                                ? `<a href="https://wa.me/${matchedProduct.user.phone.replace('+', '')}" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>`
                                // Not logged in: icon with alert on click
                                : `<a href="#" onclick="showLoginAlert(); return false;"><i class="fab fa-whatsapp"></i></a>`
                            // No phone in user data but still show icon if NOT logged in as blank icon (disabled)
                            : !authstoken
                                ? `<a href="#" onclick="showLoginAlert(); return false;"><i class="fab fa-whatsapp" style="opacity:0.3; cursor:default;"></i></a>`
                                : ''
                        }
                        ${
                            matchedProduct.user?.phone
                            ? authstoken
                                // Logged in: real phone link
                                ? `<a href="tel:${matchedProduct.user.phone}"><i class="fas fa-phone"></i></a>`
                                // Not logged in: icon with alert on click
                                : `<a href="#" onclick="showLoginAlert(); return false;"><i class="fas fa-phone"></i></a>`
                            // No phone in user data but still show icon if NOT logged in as blank icon (disabled)
                            : !authstoken
                                ? `<a href="#" onclick="showLoginAlert(); return false;"><i class="fas fa-phone" style="opacity:0.3; cursor:default;"></i></a>`
                                : ''
                        }
                    </div>
                    <div class="product_description">
                        <h3>About</h3>
                        <p>${matchedProduct.description || 'No description available.'}</p>
                    </div>
                </div>
            `;

            document.getElementById('product_detail_container').innerHTML = html;

            // ✅ Now passing industryId properly
            loadSimilarProducts(matchedProduct, matchedProduct.user?.id, industryId);
        } else {
            document.getElementById('product_detail_container').innerHTML = '<p style="padding:20px">Product not found.</p>';
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
        document.getElementById('product_detail_container').innerHTML = '<p style="padding:20px">Failed to load product details.</p>';
    });
</script>

<script>
    function loadSimilarProducts(currentProduct, userId, industryId) {
        const tokenss = localStorage.getItem("authToken");

        const similarProductsURL = tokenss 
            ? `<?php echo BASE_URL; ?>/product/get_products`
            : `<?php echo BASE_URL; ?>/get_products`;

        const headersObj = {
            "Content-Type": "application/json"
        };
        if (tokenss) {
            headersObj["Authorization"] = `Bearer ${tokenss}`;
        }

        if (!industryId) {
            console.warn("No industry ID found in product.");
            document.getElementById('similar_product_section').style.display = 'none';
            return;
        }

        fetch(similarProductsURL, {
            method: "POST",
            headers: headersObj,
            body: JSON.stringify({ industry: String(industryId) })
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                const sameIndustryProducts = result.data
                    .filter(p => p.product_name !== currentProduct.product_name)
                    .slice(0, 4);

                const isDisabled = !tokenss;

                if (sameIndustryProducts.length > 0) {
                    const cardsHTML = sameIndustryProducts.map(product => {
                        const productLink = `pages/product_detail?id=${encodeURIComponent(product.id)}`;
                        const image = product.image?.[0] || 'uploads/placeholder.png';
                        const phone = product.user?.mobile || '';
                        const whatsapp = product.user?.whatsapp || phone;

                        return `
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
                        </div>
                        `;
                    }).join('');

                    document.getElementById('similar_product_grid').innerHTML = cardsHTML;
                    document.getElementById('similar_product_section').style.display = 'block';
                } else {
                    document.getElementById('similar_product_section').style.display = 'none';
                }
            }
        })
        .catch(err => {
            console.error("Failed to load similar products:", err);
            document.getElementById('similar_product_section').style.display = 'none';
        });
    }

    // for wishlist and share
    document.addEventListener("click", async (e) => {
        const authToken = localStorage.getItem("authToken");
        const userId = localStorage.getItem("user_id");

        // Wishlist Button
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
                window.location.href = "login"; // replace with your actual login page
            }
        });
    }
</script>

<?php include("../footer.php") ?>