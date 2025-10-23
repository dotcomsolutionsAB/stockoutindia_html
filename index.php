<?php include("header.php") ?>
<?php include("configs/config_static_data.php"); ?>
<!-- Home Pages -->
<main class="main global_page">

  <?php include("inc_files/slider_section.php"); ?>

  <?php include("inc_files/home_page_products.php"); ?>


</main>
<!-- End Home Pages -->

<style>
  .like-pop { animation: like-pop .35s ease-out; }
  @keyframes like-pop { 0%{transform:scale(1)}40%{transform:scale(1.35)}100%{transform:scale(1)} }

  .unlike-pop { animation: unlike-pop .25s ease-in; }
  @keyframes unlike-pop { 0%{transform:scale(1)}100%{transform:scale(.85)} }

  .disabled-btn { pointer-events: none; opacity: .6; }
</style>
<script>
  const apiUrl = `<?php echo BASE_URL; ?>/get_products`;
  // const token = localStorage.getItem("authtoken");
  // const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

  async function fetchProducts() {
    const token = localStorage.getItem("authToken");

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
    const authToken = localStorage.getItem("authToken");
    const isGuest = !authToken;          // true → user not logged in

     let html = ''; 

    products.forEach((product, index) => {
        if (index !== 0 && index % 4 === 0) {
            html += '<div class="w-100"></div>';
        }

        // html += cardTemplate;   
        const image = product.image?.[0] || "uploads/placeholder.png";
        const productLink = `pages/product_detail?id=${product.id}`;
        /* phone can be phone or mobile; strip the leading “+” */
        const rawPhone  = product.user?.phone || product.user?.mobile || '';
        const phone     = rawPhone.trim();                       // KEEP the “+”
        const waPhone   = phone.replace(/^\+/, '');              // remove “+” only for WA
        const hasPhone  = waPhone !== '';  

        const callBtnClass = isGuest ? 'disabled-btn' : '';
        const waBtnClass   = isGuest ? 'disabled-btn' : '';


        const card = `
            <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
              <div class="product-card bg-white">
                  <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-4 card_side_icon">
                      <i class="fa-regular fa-heart text-danger wishlist-btn" data-id="${product.id}"
                        title="Add to wishlist" style="cursor:pointer;">
                      </i>

                      <i class="fa-solid fa-share text-danger share-btn" data-id="${product.id}"
                        title="Copy share link" style="cursor:pointer;">
                      </i>
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
              class="btn btn-success w-50 rounded-0 rounded-bottom-start ${waBtnClass}"
              ${hasPhone ? `onclick="handleWhatsApp('${waPhone}')"` : ''}
            >
              <i class="fa-brands fa-whatsapp"></i>
            </button>
            <button
              class="btn btn-danger w-50 rounded-0 rounded-bottom-end ${callBtnClass}"
              ${hasPhone ? `onclick="handleCall('${phone}')"` : ''}
            >
              <i class="fa-solid fa-phone"></i>
            </button>
          </div>
              </div>
            </div>
        `;

        html += card;
    });
    container.innerHTML = html; 
  }
  function handleWhatsApp(number) {
    const authToken = localStorage.getItem("authToken");
    if (!authToken) {
      showLoginAlert();
      return;
    }
    if (!number) return;
    window.open(`https://wa.me/${number}?text=${encodeURIComponent('Hi')}`, '_blank');
  }
  function handleCall(number) {
    const authToken = localStorage.getItem("authToken");
    if (!authToken) {
      showLoginAlert();
      return;
    }
    if (!number) return;
    window.location.href = `tel:${number}`;
  }
  function showLoginAlert() {
    Swal.fire({
      title: "Login Required",
      text: "Please log in to contact the seller.",
      icon: "warning",
      confirmButtonText: "Login",
      showCancelButton: true,
      cancelButtonText: "Cancel",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "login"; // Replace with your login page
      }
    });
  }

  // for wishlist and share
  document.addEventListener("click", async (e) => {
    const authToken = localStorage.getItem("authToken");
    const userId = localStorage.getItem("user_id");

      /* ❤️ Wishlist */
    const heartEl = e.target.closest(".wishlist-btn");
    if (!heartEl) return;

    const productId = parseInt(heartEl.dataset.id || 0, 10);

    if (!authToken || !userId || !productId) {
      Swal.fire("Login First", "Please log in to use wishlist.", "warning");
      return;
    }

    // Guard: prevent rapid double-clicks while request in flight
    if (heartEl.dataset.busy === "1") return;
    heartEl.dataset.busy = "1";

    const isCurrentlySolid = heartEl.classList.contains("fa-solid");

    try {
      if (!isCurrentlySolid) {
        /* =============== ADD =============== */
        // optimistic UI
        heartEl.classList.remove("fa-regular");
        heartEl.classList.add("fa-solid", "like-pop");

        const res = await fetch(`<?php echo BASE_URL; ?>/wishlist/add`, {
          method: "POST",
          headers: {
            "Authorization": `Bearer ${authToken}`,
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            user_id: parseInt(userId, 10),
            product_id: productId
          })
        });

        const result = await res.json();

        if (result.success) {
          Toastify({
            text: "Added to wishlist ❤️",
            duration: 1800,
            gravity: "bottom",
            position: "center",
            backgroundColor: "#b30000"
          }).showToast();
        } else {
          // Revert if server says no (except “already exists”: keep solid if you prefer)
          if ((result.message || "").toLowerCase().includes("already")) {
            // keep it solid (no revert), show soft info
            Toastify({
              text: result.message || "Already in wishlist ❤️",
              duration: 1500,
              gravity: "bottom",
              position: "center",
              backgroundColor: "#ff9800"
            }).showToast();
          } else {
            heartEl.classList.remove("fa-solid");
            heartEl.classList.add("fa-regular");
            Swal.fire("Error", result.message || "Could not add to wishlist", "error");
          }
        }
        setTimeout(() => heartEl.classList.remove("like-pop"), 400);

      } else {
        /* =============== REMOVE =============== */
        // optimistic UI
        heartEl.classList.add("unlike-pop");

        const res = await fetch(`<?php echo BASE_URL; ?>/wishlist/${productId}`, {
          method: "DELETE",
          headers: {
            "Authorization": `Bearer ${authToken}`,
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ user_id: parseInt(userId, 10) })
        });

        const result = await res.json();

        if (result.success) {
          // turn back to outline
          heartEl.classList.remove("fa-solid");
          heartEl.classList.add("fa-regular");
          Toastify({
            text: "Removed from wishlist",
            duration: 1500,
            gravity: "bottom",
            position: "center",
            backgroundColor: "#28a745"
          }).showToast();
        } else {
          // keep it solid; removal failed
          Swal.fire("Info", result.message || "Could not remove item", "info");
        }

        setTimeout(() => heartEl.classList.remove("unlike-pop"), 280);
      }
    } catch (err) {
      console.error(err);
      Swal.fire("Error", "Request failed", "error");
      // If we optimistically changed UI, try to revert to safe state:
      if (!isCurrentlySolid) {
        heartEl.classList.remove("fa-solid");
        heartEl.classList.add("fa-regular");
      }
    } finally {
      heartEl.dataset.busy = "0";
    }

    /* 📤 Share */
    const shareEl = e.target.closest(".share-btn");
    if (shareEl) {
      const productId = shareEl.dataset.id;
      if (!productId) return;

      const shareUrl = `https://stockoutindia.com/pages/product_detail?id=${productId}`;

      try {
        await navigator.clipboard.writeText(shareUrl);
        Toastify({
          text: "Copied link to clipboard 🔗",
          duration: 2000,
          gravity: "bottom",
          position: "center",
          backgroundColor: "#28a745"
        }).showToast();
      } catch {
        Swal.fire("Oops!", "Clipboard not supported!", "error");
      }
    }

  });

  fetchProducts(); // Call on page load
</script>
<?php include("footer.php") ?>
