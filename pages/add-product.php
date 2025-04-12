<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 
<?php include("../configs/auth_check.php"); ?>
<!-- Home Pages -->
<main class="main my_product_page">

    <section class="popular-products">
        <div class="container mt-4">
            <h2 class="section-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">Add Products</h2>
            <div class="container py-2">
                <div id="product-container" class="row gy-4 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">

                </div>
            </div>
        </div>
    </section>

</main>
<!-- End Home Pages -->

<script>
  const apiUrl = `<?php echo BASE_URL; ?>/get_products`;
  const token = localStorage.getItem("authtoken");
  // const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

  async function fetchProducts() {
    const token = localStorage.getItem("authtoken");

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
      const card = `
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
<?php include("../footer.php") ?>