
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
        container.insertAdjacentHTML("beforeend", `<div class="w-100"></div>`);
      }

      const image = product.image?.[0] || "uploads/placeholder.png";
      const productLink = `pages/product_detail.php?id=${product.id}`;
      const isInactive = product.status === "in-active";

      const actionButtons = isInactive
        ? `
          <div class="d-flex bottom-btns index_page_card">
            <button class="pays btn btn-danger w-100 rounded-0 rounded-bottom" onclick="location.href='pages/make-payment.php?product_id=${product.id}'">
              <i class="fa-solid fa-credit-card"></i>
              <span class="make_pay"> Activate Listing </span>
            </button>
          </div>
        `
        : `
          <div class="d-flex bottom-btns index_page_card">
            <button class="btn btn-success w-50 rounded-0 rounded-bottom-start">
              <i class="fa-brands fa-whatsapp"></i>
            </button>
            <button class="btn btn-danger w-50 rounded-0 rounded-bottom-end">
              <i class="fa-solid fa-phone"></i>
            </button>
          </div>
        `;

      const cardId = `deleteProduct_${product.id}`;
      const card = `
        <div class="col-12 col-sm-6 p_card col-md-3 d-flex justify-content-center">
          <div class="product-card bg-white">
            <a href="javascript:void(0);" class="updateProductBtn" data-id="${product.id}">
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
                    <div class="lower_left">
                      <p class="p_user fw-semibold mb0">Dealer: 
                          ${product.user?.name 
                              ? (product.user.name.length > 15 
                                  ? product.user.name.substring(0, 12) + '...' 
                                  : product.user.name)
                              : "N/A"}
                      </p>
                      <p>${product.status}</p>
                    </div>
                    <div class="lower_right">
                      <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">₹${product.selling_price}/${product.unit}</p>
                      <p>${product.validity}</p>
                    </div>
                </div>                          
            </div>
            ${actionButtons}
            <div class="delete-box">
              ${product.status === "active"
                ? `<a href="javascript:void(0);" class="mark-sold" data-id="${product.id}">
                      Marked To Sold <i class="fa-solid fa-check-to-slot"></i>
                    </a>
                  `
                : `<a href="javascript:void(0);" id="${cardId}">
                      <i class="fa-regular fa-trash-can"></i> Delete
                  </a>`
              }
            </div>
          </div>
        </div>
      `;

      // Insert card into DOM
      container.insertAdjacentHTML("beforeend", card);

      document.addEventListener("click", async (e) => {
        const soldBtn = e.target.closest(".mark-sold");
        if (!soldBtn) return;

        const productId = soldBtn.dataset.id;
        const authToken = localStorage.getItem("authToken");

        if (!authToken) {
          Swal.fire("Unauthorized", "Please login to mark as sold.", "error");
          return;
        }

        const confirm = await Swal.fire({
          title: "Are you sure?",
          text: "This will mark the product as sold.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, mark as sold"
        });

        if (!confirm.isConfirmed) return;

        try {
          const response = await fetch(`<?php echo BASE_URL; ?>/product/update_status`, {
            method: "POST",
            headers: {
              "Authorization": `Bearer ${authToken}`,
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              product: parseInt(productId),
              status: "sold"
            })
          });

          const result = await response.json();

          if (result.success) {
            Swal.fire("Marked!", "Product marked as sold successfully.", "success").then(() => {
              location.reload(); // or re-render if you prefer
            });
          } else {
            Swal.fire("Error", result.message || "Could not mark as sold.", "error");
          }
        } catch (err) {
          Swal.fire("Error", "Failed to update status.", "error");
        }
      });

      // Delay binding event to ensure DOM has it
      setTimeout(() => {
        const deleteBtn = document.getElementById(cardId);
        if (deleteBtn && product.status !== "active") {
          deleteBtn.addEventListener("click", async function () {
            const authToken = localStorage.getItem("authToken");

            if (!authToken) {
              Swal.fire("Unauthorized", "Please login to perform this action.", "error");
              return;
            }

            const confirm = await Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Yes, delete it!"
            });

            if (confirm.isConfirmed) {
              try {
                const response = await fetch(`<?php echo BASE_URL; ?>/product/${product.id}`, {
                  method: "DELETE",
                  headers: {
                    "Authorization": `Bearer ${authToken}`,
                    "Content-Type": "application/json"
                  }
                });

                const result = await response.json();

                if (result.success) {
                  Swal.fire("Deleted!", "Your product has been deleted.", "success");
                  this.closest('.col-12').remove();
                } else {
                  Swal.fire("Error", result.message || "Something went wrong.", "error");
                }
              } catch (error) {
                Swal.fire("Error", "Failed to delete the product.", "error");
              }
            }
          });
        }
      }, 10); // slight delay for DOM readiness
    });
  }

  fetchProducts(); // Auto-run on load
</script>

<!-- <script>
  document.addEventListener("click", async (e) => {
    const soldBtn = e.target.closest(".mark-sold");
    if (!soldBtn) return;

    const productId = soldBtn.id;
    const token = localStorage.getItem("authToken");

    if (!token) {
      Swal.fire("Unauthorized", "Please log in to mark as sold.", "warning");
      return;
    }

    // Optional confirmation
    const confirm = await Swal.fire({
      title: "Are you sure?",
      text: "Do you want to mark this product as sold?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, mark as sold"
    });

    if (!confirm.isConfirmed) return;

    try {
      const response = await fetch(`<?php echo BASE_URL; ?>/product/update_status`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({
          product: parseInt(productId),
          status: "sold"
        })
      });

      const res = await response.json();

      if (res.success) {
        Swal.fire("✅ Marked!", "Product has been marked as sold.", "success").then(() => location.reload());
      } else {
        Swal.fire("❌ Failed", res.message || "Something went wrong.", "error");
      }

    } catch (err) {
      Swal.fire("Error", "API request failed.", "error");
    }
  });

</script> -->

<script>
  const Token = localStorage.getItem("authToken");

  const head = {
    "Content-Type": "application/json"
  };
  if (Token) head["Authorization"] = `Bearer ${Token}`;

  // Click handler
  // document.addEventListener("click", async (e) => {
  //   const btn = e.target.closest(".updateProductBtn");
  //   if (!btn) return;

  //   if (!Token) {
  //     Swal.fire("Unauthorized", "Please log in to update product.", "warning");
  //     return;
  //   }

  //   const productName = btn.dataset.name;

  //   // ✅ Fetch product details by name
  //   const res = await fetch(`<?php echo BASE_URL; ?>/product/get_products`, {
  //     method: "POST",
  //     headers: head,
  //     body: JSON.stringify({ search: productName, limit: 1 })
  //   });
  //   const result = await res.json();
  //   const product = result?.data?.find(p => p.product_name === productName);

  //   if (!product) {
  //     Swal.fire("Error", "Product not found.", "error");
  //     return;
  //   }

  //   const unitRes = await fetch(`<?php echo BASE_URL; ?>/product/get_units`, { headers: head });
  //   const unitResult = await unitRes.json();
  //   const get_units = unitResult?.data || [];

  //   const unitOptions = get_units.map(unit =>
  //     `<option value="${unit}" ${unit === product.unit ? 'selected' : ''}>${unit}</option>`
  //   ).join('');


  //   // ✅ Fetch states
  //   const stateRes = await fetch(`<?php echo BASE_URL; ?>/states`, { headers: head });
  //   const stateResult = await stateRes.json();
  //   const states = stateResult?.data || [];

  //   // ✅ Fetch cities
  //   let cities = [];
  //   if (product.state_id) {
  //     const cityRes = await fetch(`<?php echo BASE_URL; ?>/cities?state_id=${product.state_id}`, { headers: head });
  //     const cityResult = await cityRes.json();
  //     cities = cityResult?.data || [];
  //   }

  //   const stateOptions = states.map(state =>
  //     `<option value="${state.id}" ${state.id == product.state_id ? 'selected' : ''}>${state.name}</option>`
  //   ).join('');

  //   const cityOptions = cities.map(city =>
  //     `<option value="${city.id}" ${city.id == product.city ? 'selected' : ''}>${city.name}</option>`
  //   ).join('');

  //   // ✅ Show popup
  //   Swal.fire({
  //     title: 'Product Preview',
  //     html: `
  //       <style>
  //         .swal2-popup {
  //           width: 900px !important;
  //         }
  //         .swal2-popup .form-grid {
  //           display: grid;
  //           grid-template-columns: repeat(3, 1fr);
  //           gap: 15px;
  //           margin-top: 10px;
  //         }
  //         .swal2-popup .form-grid label {
  //           display: block;
  //           font-weight: 600;
  //           margin-bottom: 4px;
  //           font-size: 13px;
  //           color: #b30000; /* red primary */
  //           text-align: left;
  //         }
  //         .swal2-popup .form-grid input,
  //         .swal2-popup .form-grid textarea,
  //         .swal2-popup .form-grid select {
  //           width: 100%;
  //           padding: 8px 10px;
  //           font-size: 14px;
  //           border: 1px solid #ccc;
  //           border-radius: 4px;
  //           box-sizing: border-box;
  //         }
  //         .swal2-popup .form-grid textarea {
  //           resize: vertical;
  //           min-height: 100px;
  //           grid-column: span 3;
  //         }
  //         .swal2-popup .swal2-actions {
  //           justify-content: space-between;
  //           padding: 0 15px;
  //         }
  //         .swal2-popup .swal2-cancel {
  //           background: #6c757d;
  //         }
  //         .swal2-popup .swal2-confirm {
  //           background: #b30000;
  //         }
  //       </style>

  //       <div class="form-grid">
  //         <div>
  //           <label>Product Name</label>
  //           <input value="${product.product_name}" id="product_name" disabled>
  //         </div>
  //         <div>
  //           <label>Original Price</label>
  //           <input value="${product.original_price}" id="original_price">
  //         </div>
  //         <div>
  //           <label>Selling Price</label>
  //           <input value="${product.selling_price}" id="selling_price">
  //         </div>
  //         <div>
  //           <label>Minimum Quantity</label>
  //           <input value="${product.minimum_quantity}" id="minimum_quantity">
  //         </div>
  //         <div>
  //           <label>Offer Quantity</label>
  //           <input value="${product.offer_quantity}" id="offer_quantity">
  //         </div>
  //         <div>
  //           <label>Unit</label>
  //           <select id="unit_select">${unitOptions}</select>
  //         </div>
  //         <div>
  //           <label>Industry</label>
  //           <input value="${product.industry_details?.name || 'N/A'}" disabled>
  //         </div>
  //         <div>
  //           <label>Sub-Industry</label>
  //           <input value="${product.sub_industry_details?.name || 'N/A'}" disabled>
  //         </div>
  //         <div>
  //           <label>State</label>
  //           <select id="state_select">${stateOptions}</select>
  //         </div>
  //         <div>
  //           <label>City</label>
  //           <select id="city_select">${cityOptions}</select>
  //         </div>
  //         <div>
  //           <label>Dimensions</label>
  //           <input value="${product.dimensions || ''}" id="dimensions">
  //         </div>
  //         <div style="grid-column: span 3;">
  //           <label>Description</label>
  //           <textarea id="description">${product.description || ''}</textarea>
  //         </div>
  //       </div>
  //     `,
  //     showCancelButton: true,
  //     showConfirmButton: true,
  //     confirmButtonText: 'Update',
  //     cancelButtonText: 'Close',

  //     didOpen: () => {
  //       const stateSelect = document.getElementById("state_select");
  //       stateSelect.addEventListener("change", async () => {
  //         const stateId = stateSelect.value;
  //         const cityRes = await fetch(`<?php echo BASE_URL; ?>/cities?state_id=${stateId}`, { headers: head });
  //         const cityResult = await cityRes.json();
  //         const citySelect = document.getElementById("city_select");
  //         if (cityResult.success) {
  //           citySelect.innerHTML = cityResult.data.map(city =>
  //             `<option value="${city.id}">${city.name}</option>`).join('');
  //         }
  //       });
  //     },

  //     preConfirm: async () => {
  //       const payload = {
  //         product_name: product.product_name,
  //         original_price: parseFloat(document.getElementById("original_price").value),
  //         selling_price: parseFloat(document.getElementById("selling_price").value),
  //         offer_quantity: parseInt(document.getElementById("offer_quantity").value),
  //         minimum_quantity: parseInt(document.getElementById("minimum_quantity").value),
  //         unit: document.getElementById("unit_select").value,
  //         state_id: parseInt(document.getElementById("state_select").value),
  //         city: document.getElementById("city_select").value, // ✅ now passed as string
  //         dimensions: document.getElementById("dimensions").value,
  //         description: document.getElementById("description").value,
  //         // status: "active"
  //       };

  //       try {
  //         const updateRes = await fetch(`<?php echo BASE_URL; ?>/product/update/${product.id}`, {
  //           method: "POST",
  //           headers: head,
  //           body: JSON.stringify(payload)
  //         });

  //         const updateResult = await updateRes.json();
  //         if (updateResult.success) {
  //           Swal.fire("Updated!", "Product updated successfully.", "success").then(() => location.reload());
  //         } else {
  //           Swal.showValidationMessage(updateResult.message || "Update failed.");
  //         }
  //       } catch (err) {
  //         Swal.showValidationMessage("Request failed.");
  //       }
  //     }
  //   });
  // });

  document.addEventListener("click", async (e) => {
      const btn = e.target.closest(".updateProductBtn");
      if (!btn) return;

      const productId = btn.dataset.id;
      const Token = localStorage.getItem("authToken");

      if (!Token) {
        Swal.fire("Unauthorized", "Please log in to update product.", "warning");
        return;
      }

      const head = {
        Authorization: `Bearer ${Token}`,
        "Content-Type": "application/json"
      };

      // ✅ Fetch product by ID
      const res = await fetch(`<?php echo BASE_URL; ?>/product/get_products/${productId}`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${Token}`,
          "Content-Type": "application/json"
        }
      });

      const result = await res.json();
      const product = result?.data;

      if (!product) {
        Swal.fire("Error", "Product not found.", "error");
        return;
      }         

      // Fetch units, states, cities
      const unitRes = await fetch(`<?php echo BASE_URL; ?>/product/get_units`, { headers: head });
      const unitResult = await unitRes.json();
      const get_units = unitResult?.data || [];

      const unitOptions = get_units.map(unit =>
        `<option value="${unit}" ${unit === product.unit ? 'selected' : ''}>${unit}</option>`
      ).join('');

      const stateRes = await fetch(`<?php echo BASE_URL; ?>/states`, { headers: head });
      const stateResult = await stateRes.json();
      const states = stateResult?.data || [];

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
        `<option value="${city.name}" ${city.name == product.city ? 'selected' : ''}>${city.name}</option>`
      ).join('');

      // ✅ Build image previews
      const imageHtml = product.image?.map((img, index) => `
        <div class="image-thumb">
          <img src="${img}" alt="product image ${index}" />
          <i class="fa fa-trash delete-img-icon" data-img="${img}" data-id="${productId}"></i>
        </div>
      `).join('') || `<p style="color:#999;">No images available.</p>`;

      // ✅ Show SweetAlert with full form
      Swal.fire({
        title: 'Product Preview',
        html: `
          <style>
            .swal2-popup { width: 950px !important; }
            .form-grid {
              display: grid;
              grid-template-columns: repeat(3, 1fr);
              gap: 15px;
              margin-top: 10px;
            }
            .form-grid label {
              font-weight: 600;
              font-size: 13px;
              margin-bottom: 4px;
              color: #b30000;
              text-align: left;
              display: block;
            }
            .form-grid input,
            .form-grid select,
            .form-grid textarea {
              width: 100%;
              padding: 8px 10px;
              border: 1px solid #ccc;
              border-radius: 4px;
              font-size: 14px;
            }
            .form-grid textarea {
              resize: vertical;
              min-height: 100px;
              grid-column: span 3;
            }
            .image-preview-container {
              grid-column: span 3;
              display: flex;
              flex-wrap: wrap;
              gap: 10px;
              margin-top: 10px;
            }
            .image-thumb {
              position: relative;
              width: 90px;
              height: 90px;
              border: 1px solid #ddd;
              border-radius: 6px;
              overflow: hidden;
            }
            .image-thumb img {
              width: 100%;
              height: 100%;
              object-fit: cover;
            }
            .delete-img-icon {
              position: absolute;
              top: 2px;
              right: 2px;
              color: white;
              background: red;
              border-radius: 50%;
              padding: 2px 5px;
              cursor: pointer;
              font-size: 13px;
            }
          </style>

          <div class="form-grid">
            <div><label>Product Name</label><input value="${product.product_name}" disabled></div>
            <div><label>Original Price</label><input value="${product.original_price}" id="original_price"></div>
            <div><label>Selling Price</label><input value="${product.selling_price}" id="selling_price"></div>
            <div><label>Minimum Quantity</label><input value="${product.minimum_quantity}" id="minimum_quantity"></div>
            <div><label>Offer Quantity</label><input value="${product.offer_quantity}" id="offer_quantity"></div>
            <div><label>Unit</label><select id="unit_select">${unitOptions}</select></div>
            <div><label>Industry</label><input value="${product.industry_details?.name || 'N/A'}" disabled></div>
            <div><label>Sub-Industry</label><input value="${product.sub_industry_details?.name || 'N/A'}" disabled></div>
            <div><label>State</label><select id="state_select">${stateOptions}</select></div>
            <div><label>City</label><select id="city_select">${cityOptions}</select></div>
            <div><label>Dimensions</label><input value="${product.dimensions || ''}" id="dimensions"></div>
            <div><label>Upload New Images</label><input type="file" id="upload_images_input" accept="image/*" multiple></div>
            <div style="grid-column: span 3;"><label>Description</label><textarea id="description">${product.description || ''}</textarea></div>
            <div class="image-preview-container">${imageHtml}</div>
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
                `<option value="${city.name}">${city.name}</option>`).join('');
            }
          });

          // 🗑 Handle image delete
          document.querySelectorAll(".delete-img-icon").forEach(icon => {
            icon.addEventListener("click", async () => {
              const imgUrl = icon.dataset.img;
              const id = icon.dataset.id;

              const confirmed = await Swal.fire({
                title: "Delete Image?",
                text: "Are you sure you want to delete this image?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
              });

              if (confirmed.isConfirmed) {
                try {
                  const delRes = await fetch(`<?php echo BASE_URL; ?>/product/delete_image`, {
                    method: "POST",
                    headers: head,
                    body: JSON.stringify({ product_id: id, image_url: imgUrl })
                  });
                  const delResult = await delRes.json();
                  if (delResult.success) {
                    Swal.fire("Deleted!", "Image has been deleted.", "success").then(() => location.reload());
                  } else {
                    Swal.fire("Failed", delResult.message || "Unable to delete.", "error");
                  }
                } catch (err) {
                  Swal.fire("Error", "Image delete failed.", "error");
                }
              }
            });
          });
        },

        // preConfirm: async () => {
        //   const payload = {
        //     product_name: product.product_name,
        //     original_price: parseFloat(document.getElementById("original_price").value),
        //     selling_price: parseFloat(document.getElementById("selling_price").value),
        //     offer_quantity: parseInt(document.getElementById("offer_quantity").value),
        //     minimum_quantity: parseInt(document.getElementById("minimum_quantity").value),
        //     unit: document.getElementById("unit_select").value,
        //     state_id: parseInt(document.getElementById("state_select").value),
        //     city: document.getElementById("city_select").value,
        //     description: document.getElementById("description").value,
        //     dimensions: document.getElementById("dimensions").value
        //   };

        //   try {
        //     const updateRes = await fetch(`<?php echo BASE_URL; ?>/product/update/${productId}`, {
        //       method: "POST",
        //       headers: head,
        //       body: JSON.stringify(payload)
        //     });

        //     const updateResult = await updateRes.json();
        //     if (updateResult.success) {
        //       Swal.fire("Updated!", "Product updated successfully.", "success").then(() => location.reload());
        //     } else {
        //       Swal.showValidationMessage(updateResult.message || "Update failed.");
        //     }
        //   } catch (err) {
        //     Swal.showValidationMessage("Request failed.");
        //   }
        // }
        preConfirm: async () => {
            const payload = {
              product_name: product.product_name,
              original_price: parseFloat(document.getElementById("original_price").value),
              selling_price: parseFloat(document.getElementById("selling_price").value),
              offer_quantity: parseInt(document.getElementById("offer_quantity").value),
              minimum_quantity: parseInt(document.getElementById("minimum_quantity").value),
              unit: document.getElementById("unit_select").value,
              state_id: parseInt(document.getElementById("state_select").value),
              city: document.getElementById("city_select").value,
              description: document.getElementById("description").value,
              dimensions: document.getElementById("dimensions").value
            };

            try {
              // ✅ Step 1: Update product
              const updateRes = await fetch(`<?php echo BASE_URL; ?>/product/update/${productId}`, {
                method: "POST",
                headers: head,
                body: JSON.stringify(payload)
              });

              const updateResult = await updateRes.json();

              if (!updateResult.success) {
                Swal.showValidationMessage(updateResult.message || "Update failed.");
                return;
              }

              // ✅ Step 2: Upload images if selected
              const fileInput = document.getElementById("upload_images_input");
              const files = fileInput.files;

              if (files.length > 0) {
                const formData = new FormData();
                for (let i = 0; i < files.length; i++) {
                  formData.append("files[]", files[i]);
                }

                const imageUpload = await fetch(`<?php echo BASE_URL; ?>/product/images/${productId}`, {
                  method: "POST",
                  headers: {
                    Authorization: `Bearer ${Token}` // Do NOT add Content-Type here
                  },
                  body: formData
                });

                const imageRes = await imageUpload.json();
                if (!imageRes.success) {
                  Swal.fire("⚠️", "Product updated, but image upload failed.", "warning").then(() => location.reload());
                  return;
                }
              }

              // ✅ Step 3: Reload after everything
              Swal.fire("✅ Updated!", "Product & Images updated successfully!", "success").then(() => location.reload());

            } catch (err) {
              Swal.showValidationMessage("Something went wrong.");
            }
          }

      });
  });
</script>




