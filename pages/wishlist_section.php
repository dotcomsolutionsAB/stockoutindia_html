<div class="wishlist global_page">
    <h3>Wishlist Items</h3>
    <div id="wishlist-container" class="row">

    </div>
</div>

<script>
  async function fetchWishlistProducts() {
    const authToken = localStorage.getItem("authToken");
    const userId = localStorage.getItem("user_id");
    const container = document.getElementById("wishlist-container");

    if (!authToken || !userId) {
      Swal.fire("Unauthorized", "Please log in to view your wishlist.", "warning");
      return;
    }

    try {
      const res = await fetch(`<?php echo BASE_URL; ?>/wishlist/fetch`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${authToken}`
        },
        body: JSON.stringify({ user_id: parseInt(userId) })
      });

      const result = await res.json();

      if (!result.success) {
        Swal.fire("Error", result.message || "Unable to fetch wishlist.", "error");
        return;
      }

      const wishlist = result.data || [];
      container.innerHTML = "";

      if (wishlist.length === 0) {
        container.innerHTML = `<div class="text-center w-100 text-muted py-4">No wishlist products found.</div>`;
        return;
      }

      wishlist.forEach((item) => {
        const product = item.product;
        const image = product.image?.[0] || "uploads/placeholder.png";
        const productLink = `pages/product_detail.php?id=${product.id}`;
        const whatsapp = product.user?.phone || "";
        const phone = product.user?.phone || "";

        const card = `
          <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
            <div class="product-card bg-white">
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
                        ${product.product_name.length > 30 ? product.product_name.substring(0, 27) + '...' : product.product_name}
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
                      ? (product.user.name.length > 15 ? product.user.name.substring(0, 12) + '...' : product.user.name)
                      : "N/A"}
                  </p>
                  <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">
                    ₹${product.selling_price}/${product.unit}
                  </p>
                </div>
              </div>
              <div class="d-flex bottom-btns global_page_card">
                <button class="btn btn-success w-50 rounded-0 rounded-bottom-start ${!authToken ? 'disabled-btn' : ''}"
                  onclick="handleWhatsApp('${whatsapp}', ${!authToken})">
                  <i class="fa-brands fa-whatsapp"></i>
                </button>
                <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end ${!authToken ? 'disabled-btn' : ''}"
                  onclick="handleCall('${phone}', ${!authToken})">
                  <i class="fa-solid fa-phone"></i>
                </button>
              </div>
              <div class="delete-box text-center">
                <a href="javascript:void(0);" class="delete-wish" data-id="${item.product_id}">
                  Remove Item <i class="fa-solid fa-tags"></i>
                </a>
              </div>
            </div>
          </div>
        `;

        container.insertAdjacentHTML("beforeend", card);
      });

    } catch (error) {
      console.error("Wishlist fetch failed:", error);
      Swal.fire("Error", "Something went wrong while loading wishlist.", "error");
    }
  }

  // Call fetch function on load
  fetchWishlistProducts();

  // 🗑️ Remove from wishlist click handler
  document.addEventListener("click", async function (e) {
    const deleteBtn = e.target.closest(".delete-wish");
    if (!deleteBtn) return;

    const authToken = localStorage.getItem("authToken");
    const userId = localStorage.getItem("user_id");

    if (!authToken || !userId) {
      Swal.fire("Unauthorized", "Please log in to perform this action.", "warning");
      return;
    }

    const productId = deleteBtn.dataset.id;

    try {
      const res = await fetch(`<?php echo BASE_URL; ?>/wishlist/${productId}`, {
        method: "DELETE",
        headers: {
          "Authorization": `Bearer ${authToken}`,
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ user_id: parseInt(userId) })
      });

      const result = await res.json();

      if (result.success) {
        Toastify({
          text: result.message || "Removed from wishlist",
          duration: 2000,
          gravity: "top",
          position: "center",
          backgroundColor: "#28a745"
        }).showToast();

        setTimeout(() => location.reload(), 2000);
      } else {
        Swal.fire("Error", result.message || "Could not remove item", "error");
      }

    } catch (err) {
      console.error(err);
      Swal.fire("Error", "Failed to remove item", "error");
    }
  });
</script>