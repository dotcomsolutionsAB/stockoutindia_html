
<!-- Home Pages -->
<main class="main my_product_page global_page">

    <section class="popular-products">
        <div class="contnr">
            <h2 class="section-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">My Products</h2>
            <div class="contnrr">
                <div id="product-container" class="row gy-4 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">

                </div>
            </div>
        </div>
    </section>

</main>
<!-- End Home Pages -->

<script>
  const BASE_URL = "<?php echo BASE_URL; ?>";
  // const authToken = localStorage.getItem("authtoken");
  const userId = localStorage.getItem("user_id");

  async function fetchProducts() {
    const headers = {
      "Content-Type": "application/json"
    };
    if (authToken) {
      headers["Authorization"] = `Bearer ${authToken}`;
    }

    const body = JSON.stringify({
      user_id: userId || "",  // If not found, pass empty to fetch all
      limit: 14,
      offset: 0
    });

    try {
      const response = await fetch(`${BASE_URL}/product/get_products`, {
        method: "POST",
        headers,
        body
      });

      const result = await response.json();

      if (result.success) {
        renderProducts(result.data.slice(0, 14)); // Show 14 products
      } else {
        alert("Failed to fetch products");
      }
    } catch (error) {
      console.error("Fetch error:", error);
    }
  }

  function renderProducts(products) {
    const container = document.getElementById("product-container");
    container.innerHTML = "";

    products.forEach((product, index) => {
      if (index % 4 === 0) {
        container.innerHTML += `<div class="w-100"></div>`;
      }

      const image = product.image?.[0] || "uploads/placeholder.png";
      const productLink = `pages/product_detail.php?name=${product.product_name}`;

      const card = `
        <div class="col-12 col-sm-6 col-md-3 d-flex justify-content-center">
          <div class="product-card bg-white">
            <span class="badge bg-danger text-white position-absolute top-0 start-0 mt-1 m-2 px-2 py-2 rounded-pill badge-featured">Featured</span>
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

  fetchProducts(); // Auto-run on load
</script>

