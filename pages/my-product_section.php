
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
  // const BASE_URL = "";
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
      const response = await fetch(`<?php echo BASE_URL; ?>/product/get_products`, {
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
            <a href="javascript:void(0);" class="updateProductBtn" data-name="${product.product_name}">
              <span class="badge bg-warning text-white position-absolute top-0 start-0 mt-1 m-2 px-2 py-2 rounded-pill badge-featured">Update</span>
            </a>
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


<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
const Token = localStorage.getItem("authToken");

const head = {
  "Content-Type": "application/json"
};
if (Token) head["Authorization"] = `Bearer ${Token}`;

// Click handler
document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".updateProductBtn");
  if (!btn) return;

  if (!Token) {
    Swal.fire("Unauthorized", "Please log in to update product.", "warning");
    return;
  }

  const productName = btn.dataset.name;

  // ✅ Fetch product details by name
  const res = await fetch(`<?php echo BASE_URL; ?>/product/get_products`, {
    method: "POST",
    headers: head,
    body: JSON.stringify({ search: productName, limit: 1 })
  });
  const result = await res.json();
  const product = result?.data?.find(p => p.product_name === productName);

  if (!product) {
    Swal.fire("Error", "Product not found.", "error");
    return;
  }

  // ✅ Fetch states
  const stateRes = await fetch(`<?php echo BASE_URL; ?>/states`, { headers: head });
  const stateResult = await stateRes.json();
  const states = stateResult?.data || [];

  // ✅ Fetch cities
  let cities = [];
  if (product.state_id) {
    const cityRes = await fetch(`<?php echo BASE_URL; ?>/cities?state_id=${product.state_id}`, { headers: head });
    const cityResult = await cityRes.json();
    cities = cityResult?.data || [];
  }

  const stateOptions = states.map(state =>
    `<option value="${state.id}" ${state.id == product.state_id ? 'selected' : ''}>${state.name}</option>`
  ).join('');

  const cityOptions = cities.map(city =>
    `<option value="${city.id}" ${city.id == product.city ? 'selected' : ''}>${city.name}</option>`
  ).join('');

  // ✅ Show popup
  Swal.fire({
    title: 'Product Preview',
    html: `
      <style>
        .swal2-popup {
          width: 900px !important;
        }
        .swal2-popup .form-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 15px;
          margin-top: 10px;
        }
        .swal2-popup .form-grid label {
          display: block;
          font-weight: 600;
          margin-bottom: 4px;
          font-size: 13px;
          color: #b30000; /* red primary */
          text-align: left;
        }
        .swal2-popup .form-grid input,
        .swal2-popup .form-grid textarea,
        .swal2-popup .form-grid select {
          width: 100%;
          padding: 8px 10px;
          font-size: 14px;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }
        .swal2-popup .form-grid textarea {
          resize: vertical;
          min-height: 100px;
          grid-column: span 3;
        }
        .swal2-popup .swal2-actions {
          justify-content: space-between;
          padding: 0 15px;
        }
        .swal2-popup .swal2-cancel {
          background: #6c757d;
        }
        .swal2-popup .swal2-confirm {
          background: #b30000;
        }
      </style>

      <div class="form-grid">
        <div>
          <label>Product Name</label>
          <input value="${product.product_name}" disabled>
        </div>

        <div>
          <label>Original Price</label>
          <input value="${product.original_price}">
        </div>

        <div>
          <label>Selling Price</label>
          <input value="${product.selling_price}">
        </div>

        <div>
          <label>Minimum Quantity</label>
          <input value="${product.minimum_quantity}">
        </div>

        <div>
          <label>Offer Quantity</label>
          <input value="${product.offer_quantity}">
        </div>

        <div>
          <label>Unit</label>
          <input value="${product.unit}">
        </div>

        <div>
          <label>Industry</label>
          <input value="${product.industry_details?.name || 'N/A'}" disabled>
        </div>

        <div>
          <label>Sub-Industry</label>
          <input value="${product.sub_industry_details?.name || 'N/A'}" disabled>
        </div>

        <div>
          <label>Status</label>
          <input value="${product.status}" disabled>
        </div>

        <div>
          <label>State</label>
          <select id="state_select">${stateOptions}</select>
        </div>

        <div>
          <label>City</label>
          <select id="city_select">${cityOptions}</select>
        </div>

        <div>
          <label>Validity</label>
          <input value="${product.validity || ''}" disabled>
        </div>

        <div>
          <label>Dimensions</label>
          <input value="${product.dimensions || ''}">
        </div>

        <div style="grid-column: span 3;">
          <label>Description</label>
          <textarea>${product.description || ''}</textarea>
        </div>
      </div>
    `,
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonText: 'Update',
    cancelButtonText: 'Close',

    didOpen: () => {
      const stateSelect = document.getElementById("state_select");
      stateSelect.addEventListener("change", async () => {
        const stateId = stateSelect.value;
        const cityRes = await fetch(`<?php echo BASE_URL; ?>/cities?state_id=${stateId}`, { headers: head });
        const cityResult = await cityRes.json();
        const citySelect = document.getElementById("city_select");

        if (cityResult.success) {
          citySelect.innerHTML = cityResult.data.map(city =>
            `<option value="${city.id}">${city.name}</option>`
          ).join('');
        }
      });
    }
  });
});
</script>


