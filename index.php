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
  // const token = localStorage.getItem("authtoken");
  // const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

  async function fetchProducts() {
    const token = localStorage.getItem("authtoken");

    const headers = {
      "Content-Type": "application/json"
    };
    let endpoint = "<?php echo BASE_URL; ?>/get_products";

    if (token) {
      headers["Authorization"] = `Bearer ${token}`;
      endpoint = "<?php echo BASE_URL; ?>/product/get_products";
    }

    const body = JSON.stringify({
      limit: 12,
      offset: 0
    });

    try {
      const response = await fetch(endpoint, {
        method: "POST",
        headers: headers,
        body: body
      });

      const result = await response.json();

      if (result.success) {
        renderProducts(result.data.slice(0, 12));
      } else {
        alert("Failed to fetch products");
      }
    } catch (error) {
      console.error("Error fetching products:", error);
      alert("An error occurred while fetching products.");
    }
  }

  function renderProducts(products) {
    const container = document.getElementById("product-container");
    container.innerHTML = "";

    const authToken = localStorage.getItem("authToken");
    const isDisabled = !authToken;

    products.forEach((product, index) => {
        if (index % 4 === 0) {
            container.innerHTML += `<div class="w-100"></div>`;
        }

        const image = product.image?.[0] || "uploads/placeholder.png";
        const productLink = `pages/product_detail.php?id=${product.id}`;
        const phone = product.user?.mobile || '';
        const whatsapp = product.user?.whatsapp || phone;

        const card = `
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
                  <div class="d-flex bottom-btns index_page_card">
                      <button 
                          class="btn btn-success w-50 rounded-0 rounded-bottom-start ${!authToken ? 'disabled-btn' : ''}" 
                          onclick="handleWhatsApp('${whatsapp}', ${!authToken})">
                          <i class="fa-brands fa-whatsapp"></i>
                      </button>
                      <button 
                          class="btn btn-danger w-50 rounded-0 rounded-bottom-end ${!authToken ? 'disabled-btn' : ''}" 
                          onclick="handleCall('${phone}', ${!authToken})">
                          <i class="fa-solid fa-phone"></i>
                      </button>
                  </div>
              </div>
            </div>
        `;

        container.innerHTML += card;
    });
  }

  // for wishlist and share
  document.addEventListener("click", async (e) => {
    const authToken = localStorage.getItem("authToken");
    const userId = localStorage.getItem("user_id");

    // ❤️ Wishlist Button
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

        const shareUrl = `https://new.stockoutindia.com/pages/product_detail.php?id=${productId}`;

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
              window.location.href = "login.php"; // replace with your actual login page
          }
      });
  }

  fetchProducts(); // Call on page load
</script>
<?php include("footer.php") ?>

<style>

</style>