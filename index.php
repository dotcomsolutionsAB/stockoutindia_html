<?php include("header.php") ?>
<?php include("configs/config_static_data.php"); ?>
<!-- Home Pages -->
<main class="main global_page">

  <?php include("inc_files/slider_section.php"); ?>

  <?php include("inc_files/home_page_products.php"); ?>
<!-- 
  <div class="banners-section mb-4">
    <div class="row row-sm">
      <div class="col-md-4">
        <div class="banner banner1 appear-animate" data-animation-name="fadeIn" data-animation-delay="200"
          style="background-color: #696f6f;">
          <figure>
            <img src="uploads/banner/banner1.jpg" alt="banner" width="640" height="640">
          </figure>
        </div>
      </div>
      <div class="col-md-8">
        <div class="banner banner2 h-100"
          style="background: #101010 no-repeat center/cover url(uploads/banner/banner2.jpg);">
          <h4 class="text-light text-uppercase mb-0 appear-animate"
                                data-animation-name="fadeInUpShorter" data-animation-delay="100">Get Ready</h4>
                            <h2 class="d-inline-block align-middle text-uppercase m-b-3 appear-animate"
                                data-animation-name="fadeInUpShorter" data-animation-delay="300">20% off</h2><a
                                href="demo27-shop.html"
                                class="btn btn-dark btn-lg align-middle m-b-3 appear-animate d-none d-sm-inline-block"
                                data-animation-name="fadeInUpShorter" data-animation-delay="300">Shop All Sale</a>
                            <h3 class="heading-border appear-animate" data-animation-name="fadeInUpShorter"
                                data-animation-delay="500">BIKES</h3>
        </div>
      </div>
    </div>
  </div> -->

</main>
<!-- End Home Pages -->

<script>
  const apiUrl = `<?php echo BASE_URL; ?>/get_products`;
  const token = localStorage.getItem("authtoken");
  // const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

  async function fetchProducts() {
    const token = localStorage.getItem("authtoken");
    // const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

    const headers = {
      "Content-Type": "application/json"
    };
    if (token) {
      headers["Authorization"] = `Bearer ${token}`;
    }

    const response = await fetch("<?php echo BASE_URL; ?>/get_products", {
      method: "POST",
      headers: headers
    });

    const result = await response.json();

    if (result.success) {
      renderProducts(result.data.slice(0, 10)); // Only show first 15
    } else {
      alert("Failed to fetch products");
    }
  }

  function renderProducts(products) {
    const container = document.getElementById("product-container");
    container.innerHTML = ""; // Clear existing cards

    products.forEach((product, index) => {
      if (index % 4 === 0) {
        container.innerHTML += `<div class="w-100"></div>`; // line break for new row
      }

      const image = product.image?.[0] || "uploads/placeholder.png";
      const productLink = `pages/product_detail.php?name=${product.product_name}`;
      const card = `
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
        `;
      container.innerHTML += card;
    });
  }

  fetchProducts(); // Call on page load
</script>
<?php include("footer.php") ?>