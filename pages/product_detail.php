<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main global_page ">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
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
    // Get the "name" from URL param
    const urlParams = new URLSearchParams(window.location.search);
    const searchName = decodeURIComponent(urlParams.get('name') || '').trim();

    // API config
    const url= "<?php echo BASE_URL; ?>/product/get_products";
    const token = localStorage.getItem("authToken");

    // Request headers
    const header = {
        "Content-Type": "application/json"
    };
    if (token) {
        header["Authorization"] = `Bearer ${token}`;
    }

    // Make API call
    fetch(url, {
        method: "POST",
        headers: header,
        body: JSON.stringify({ search: searchName })
    })
        .then(res => res.json())
        .then(result => {
            if (result.success && result.data.length > 0) {
                // Priority 1: exact match
                const matchedProduct = result.data.find(p => p.product_name === searchName) || result.data[0];

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
                        ${matchedProduct.user?.phone ? `<a href="https://wa.me/${matchedProduct.user.phone.replace('+', '')}" target="_blank"><i class="fab fa-whatsapp"></i></a>` : ''}
                        ${matchedProduct.user?.phone ? `<a href="tel:${matchedProduct.user.phone}"><i class="fas fa-phone"></i></a>` : ''}
                        </div>

                        <div class="product_description">
                        <h3>About</h3>
                        <p>${matchedProduct.description || 'No description available.'}</p>
                        </div>
                    </div>
                `;

                document.getElementById('product_detail_container').innerHTML = html;
                loadSimilarProducts(matchedProduct, matchedProduct.user?.id);
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
    function loadSimilarProducts(currentProduct, userId) {
        fetch(url, {
            method: "POST",
            headers: headers,
            body: JSON.stringify({ search: "" }) // get all
        })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    const sameSellerProducts = result.data
                        .filter(p => p.user?.name === currentProduct.user?.name && p.product_name !== currentProduct.product_name)
                        .slice(0, 4);

                    if (sameSellerProducts.length > 0) {
                        const cardsHTML = sameSellerProducts.map(product => {
                            const productLink = `pages/product_detail.php?name=${encodeURIComponent(product.product_name)}`;
                            const image = product.image?.[0] || 'uploads/placeholder.png';

                            return `
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
                                        <button class="btn btn-success w-50 rounded-0 rounded-bottom-start">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        </button>
                                        <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end">
                                        <i class="fa-solid fa-phone"></i>
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            `;
                        }).join('');

                        document.getElementById('similar_product_grid').innerHTML = cardsHTML;
                    } else {
                        document.getElementById('similar_product_section').style.display = 'none';
                    }
                }
            });
    }
</script>
<?php include("../footer.php") ?>