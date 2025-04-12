<base href="">
<?php include("header.php") ?>
<?php include("configs/config_static_data.php"); ?>

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
    <section class="similar_product_section" id="similar_product_section">
      <h2 class="similar_title">Similar Products from this Seller</h2>
      <div class="similar_product_grid" id="similar_product_grid">
        <!-- Product cards will appear here -->
      </div>
    </section>
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
        fetch(BASE_URL, {
            method: "POST",
            headers: headers,
            body: JSON.stringify({ search: "" }) // No search term; get all from dealer
        })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    const sameSellerProducts = result.data
                        .filter(p => p.user?.name === currentProduct.user?.name && p.product_name !== currentProduct.product_name)
                        .slice(0, 4); // limit to 4

                    if (sameSellerProducts.length > 0) {
                        const cardsHTML = sameSellerProducts.map(p => `
              <div class="similar_card">
                <img src="${p.image?.[0] || ''}" class="similar_card_img" alt="${p.product_name}">
                <h3 class="similar_card_title">${p.product_name}</h3>
                <p class="similar_card_price">₹ ${p.selling_price}/${p.unit}</p>
                <a href="product_detail.php?name=${encodeURIComponent(p.product_name)}" class="similar_card_link">View Details</a>
              </div>
            `).join('');

                        document.getElementById('similar_product_grid').innerHTML = cardsHTML;
                    } else {
                        document.getElementById('similar_product_section').style.display = 'none';
                    }
                }
            });
    }
</script>
<?php include("footer.php") ?>
<style>
  .similar_product_section {
    padding: 30px 20px;
    max-width: 1100px;
    margin: auto;
  }

  .similar_title {
    font-size: 20px;
    margin-bottom: 20px;
    color: #b30000;
  }

  .similar_product_grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
  }

  .similar_card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    padding: 15px;
    text-align: center;
  }

  .similar_card_img {
    width: 100%;
    height: 150px;
    object-fit: contain;
    margin-bottom: 10px;
  }

  .similar_card_title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .similar_card_price {
    color: #b30000;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .similar_card_link {
    display: inline-block;
    padding: 6px 12px;
    background-color: #b30000;
    color: white;
    font-size: 14px;
    border-radius: 5px;
    text-decoration: none;
  }

  .similar_card_link:hover {
    background-color: #8e0000;
  }

</style>