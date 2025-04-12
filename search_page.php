<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- update this path -->
   <!-- Plugins CSS File -->
   <link rel="stylesheet" href="assets/css/bootstrap.min.css">

<!-- Main CSS File -->
<!-- <link rel="stylesheet" href="assets/css/demo27.min.css"> -->
  <link rel="stylesheet" href="custom/custom.css">
  <style>
    .product-card { width: 100%; max-width: 300px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .mb0 { margin-bottom: 0 !important; }
    .card-img-top { max-height: 200px; object-fit: cover; }
    .global_page_card button i { font-size: 16px; }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="mb-4">Search Results</h2>
  <div class="row g-4" id="search_results">
    <!-- Cards will be injected here -->
  </div>
</div>

<script>
const BASE_URL = "https://api.stockoutindia.com/api";
const authToken = localStorage.getItem("authToken");

// Build headers
const headers = { "Content-Type": "application/json" };
if (authToken) headers["Authorization"] = `Bearer ${authToken}`;

// Get search and industry params from URL
const urlParams = new URLSearchParams(window.location.search);
const search = urlParams.get("q") || "";
const industry = urlParams.get("industry") || "";

fetch(`${BASE_URL}/product/get_products`, {
  method: "POST",
  headers,
  body: JSON.stringify({
    search: search,
    industry: industry,
    limit: 50,
    offset: 0
  })
})
.then(res => res.json())
.then(result => {
  const container = document.getElementById("search_results");
  if (result.success && result.data.length > 0) {
    container.innerHTML = result.data.map(product => {
      const productLink = `product_detail.php?name=${encodeURIComponent(product.product_name)}`;
      const image = product.image?.[0] || '';

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
            <div class="left_side_body">
              <a href="${productLink}">
                <h6 class="text-success fw-bold">
                  ${product.product_name.length > 30 
                    ? product.product_name.substring(0, 27) + '...' 
                    : product.product_name}
                </h6>
              </a>
              <p class="p_user fw-semibold mb0">Dealer: 
                ${product.user?.name 
                  ? (product.user.name.length > 15 
                    ? product.user.name.substring(0, 12) + '...' 
                    : product.user.name)
                  : "N/A"}
              </p>
              <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">₹${product.selling_price}/${product.unit}</p>
            </div>
            <div class="right_side_body">
              <span class="badge badge text-secondary">Qty: <strong>${product.offer_quantity}</strong></span>
              <span class="badge badge text-dark">Min: <strong>${product.minimum_quantity}</strong></span>
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
      </div>`;
    }).join('');
  } else {
    container.innerHTML = `<div class="col-12 text-center"><p>No products found.</p></div>`;
  }
});
</script>

</body>
</html>
