<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main">
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

</main>

<script>
    // Get the "name" from URL param
    const urlParams = new URLSearchParams(window.location.search);
    const searchName = decodeURIComponent(urlParams.get('name') || '').trim();

    // API config
    const BASE_URL = "<?php echo BASE_URL; ?>/product/get_products";
    const authToken = localStorage.getItem("authToken");

    // Request headers
    const headers = {
        "Content-Type": "application/json"
    };
    if (authToken) {
        headers["Authorization"] = `Bearer ${authToken}`;
    }

    // Make API call
    fetch(BASE_URL, {
        method: "POST",
        headers: headers,
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
            ${matchedProduct.user?.phone ? `<a href="tel:${matchedProduct.user.phone}"><i class="fas fa-phone-alt"></i></a>` : ''}
            </div>

            <div class="product_description">
            <h3>About</h3>
            <p>${matchedProduct.description || 'No description available.'}</p>
            </div>
        </div>
        `;

                document.getElementById('product_detail_container').innerHTML = html;
            } else {
                document.getElementById('product_detail_container').innerHTML = '<p style="padding:20px">Product not found.</p>';
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            document.getElementById('product_detail_container').innerHTML = '<p style="padding:20px">Failed to load product details.</p>';
        });
</script>

<?php include("../footer.php") ?>