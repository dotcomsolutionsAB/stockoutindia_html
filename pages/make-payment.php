<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?>

<main class="main global_page ">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Make Payment</a></li>
            </ol>
        </div>
    </nav>

    <div class="container">
        <section class="make_payment" id="make_payment">
            <h3 id="make-payment" class="text-center my-4 fw-bold text-dark"></h3>
            <div class="payment_summary_box">
                <div class="upbox">
                    <div id="product_image_box" class="product_image_wrapper"></div>
                    <h3 id="product_name" class="product_name_heading">Loading...</h3>
                </div>
                
                <div class="downbox">
                    <div class="comment_section">
                        <label for="comment_input">Comment:</label>
                        <textarea id="comment_input" rows="4" placeholder="Enter comment..."></textarea>
                    </div>
                    <h2>Total: ₹999</h2>
                </div>

                <!-- Coupon Section -->
                <!-- <div class="coupon_section mb-4">
                    <label for="coupon_select" class="fw-semibold text-dark mb-1 d-block">Apply Coupon:</label>
                    <div class="d-flex gap-2">
                        <select id="coupon_select" class="form-select" style="flex: 1;">
                            <option value="">-- Select Coupon --</option>
                        </select>
                        <button id="apply_coupon_btn" class="btn btn-sm btn-outline-success">Apply</button>
                    </div>
                    <p id="discount_info" class="text-success mt-2 fw-semibold" style="display: none;"></p>
                </div> -->
                <!-- Coupon Section -->
                <div class="coupon_section mb-4">
                    <label for="coupon_input" class="fw-semibold text-dark mb-1 d-block">Enter Coupon:</label>
                    <div class="d-flex gap-2 align-items-center">
                        <input id="coupon_input" type="text" class="form-control" placeholder="Enter coupon name" style="flex: 1;" />
                        <button id="apply_coupon_btn" class="btn btn-sm btn-outline-success" disabled>Apply</button>
                        <button id="cancel_coupon_btn" class="btn btn-sm btn-outline-danger d-none">Cancel</button>
                    </div>
                    <p id="discount_info" class="text-success mt-2 fw-semibold" style="display: none;"></p>
                </div>


                <button id="makePaymentBtn" class="make_payment_button">Make Payment</button>
            </div>
        </section>
    </div><!-- End .container -->
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const authToken = localStorage.getItem("authToken");
  const BASE_URL = "<?php echo BASE_URL; ?>";

  const urlParams = new URLSearchParams(window.location.search);
  const productId = urlParams.get("product_id");

  const productNameEl = document.getElementById("product_name");
  const productImageBox = document.getElementById("product_image_box");
  const commentInput = document.getElementById("comment_input");
  const makePaymentBtn = document.getElementById("makePaymentBtn");
  const couponInput = document.getElementById("coupon_input");
  const applyCouponBtn = document.getElementById("apply_coupon_btn");
  const cancelCouponBtn = document.getElementById("cancel_coupon_btn");
  const discountInfo = document.getElementById("discount_info");

  let productPrice = 999;
  let finalAmount = productPrice;
  let originalOrderId = "";
  let razorpay_order_id = "";
  let selectedCoupon = "";
  let couponList = [];

  commentInput.value = `Payment for order #${productId}`;

  // Step 1: Fetch product and generate initial order
  fetch(`${BASE_URL}/get_products/${productId}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": `Bearer ${authToken}`
    }
  })
  .then(res => res.json())
  .then(result => {
    if (result.success && result.data) {
      const product = result.data;
      productNameEl.textContent = product.product_name || "Product";
      const imageUrl = product.image?.[0] || "uploads/placeholder.png";
      productImageBox.innerHTML = `<img src="${imageUrl}" alt="Product Image">`;

      return generateRazorpayOrder(productPrice); // without coupon
    } else {
      throw new Error("Product not found");
    }
  })
  .then(() => {
    originalOrderId = razorpay_order_id; // Save original
  })
  .catch(err => {
    console.error("Error:", err);
    alert("Something went wrong while loading product or payment details.");
  });

  // Step 2: Fetch coupon list
  fetch(`${BASE_URL}/coupon/index`, {
    method: "GET",
    headers: {
      "Authorization": `Bearer ${authToken}`
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success && Array.isArray(data.data)) {
      couponList = data.data.filter(c => c.is_active === "1");
    }
  });

  // Step 3: Enable Apply if valid coupon entered
  couponInput.addEventListener("input", () => {
    const typed = couponInput.value.trim().toUpperCase();
    const valid = couponList.find(c => c.name.toUpperCase() === typed);
    applyCouponBtn.disabled = !valid;
  });

  // Step 4: Apply Coupon
  applyCouponBtn.addEventListener("click", () => {
    const typed = couponInput.value.trim().toUpperCase();
    const matchedCoupon = couponList.find(c => c.name.toUpperCase() === typed);

    if (!matchedCoupon) {
      alert("Invalid or inactive coupon.");
      return;
    }

    selectedCoupon = matchedCoupon.name;

    generateRazorpayOrder(productPrice, selectedCoupon).then(() => {
      document.querySelector(".downbox h2").textContent = `Total: ₹${finalAmount}`;
      discountInfo.textContent = `Coupon applied: ₹${matchedCoupon.value} OFF`;
      discountInfo.style.display = "block";

      // Lock UI
      couponInput.disabled = true;
      applyCouponBtn.classList.add("d-none");
      cancelCouponBtn.classList.remove("d-none");
    });
  });

  // Step 5: Cancel Coupon
  cancelCouponBtn.addEventListener("click", () => {
    selectedCoupon = "";
    razorpay_order_id = originalOrderId;
    finalAmount = productPrice;

    // Reset UI
    couponInput.disabled = false;
    couponInput.value = "";
    discountInfo.style.display = "none";
    applyCouponBtn.classList.remove("d-none");
    applyCouponBtn.disabled = true;
    cancelCouponBtn.classList.add("d-none");

    document.querySelector(".downbox h2").textContent = `Total: ₹${finalAmount}`;
  });

  // Step 6: Razorpay
  makePaymentBtn.addEventListener("click", () => {
    if (!razorpay_order_id) {
      return alert("Payment not ready yet. Please wait...");
    }

    const options = {
      key: "rzp_test_EVVF2DggZF1FTZ",
      amount: finalAmount * 100,
      currency: "INR",
      name: "Stockout India",
      description: "Product Purchase",
      image: "../uploads/stockout_logo.png",
      order_id: razorpay_order_id,
      handler: function (response) {
        const razorpay_payment_id = response.razorpay_payment_id;

        fetch(`${BASE_URL}/store_payment`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${authToken}`
          },
          body: JSON.stringify({
            razorpay_payment_id: razorpay_payment_id,
            product: Number(productId)
          })
        })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            window.location.href = "pages/account.php";
          } else {
            alert("Error storing payment: " + result.message);
          }
        })
        .catch(error => {
          console.error("Store payment error:", error);
          alert("Something went wrong while storing the payment.");
        });
      },
      prefill: { name: "", email: "", contact: "" },
      theme: { color: "#b30000" }
    };

    const rzp = new Razorpay(options);
    rzp.open();
  });

  // Step 7: Razorpay order generator
  function generateRazorpayOrder(amount, coupon = "") {
    return fetch(`${BASE_URL}/make_payment`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${authToken}`
      },
      body: JSON.stringify({
        payment_amount: amount,
        product: Number(productId),
        coupon: coupon || undefined,
        comments: commentInput.value
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success && data.data) {
        razorpay_order_id = data.data.razorpay_order_id;
        finalAmount = data.data.payment_amount;
      } else {
        alert("Failed to create payment order: " + data.message);
      }
    })
    .catch(error => {
      console.error("Error in Razorpay order generation:", error);
      alert("Failed to generate Razorpay order.");
    });
  }
});

</script>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const authToken = localStorage.getItem("authToken");
        const BASE_URL = "<?php echo BASE_URL; ?>";

        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get("product_id");

        const productNameEl = document.getElementById("product_name");
        const productImageBox = document.getElementById("product_image_box");
        const commentInput = document.getElementById("comment_input");
        const makePaymentBtn = document.getElementById("makePaymentBtn");
        const couponSelect = document.getElementById("coupon_select");
        const applyCouponBtn = document.getElementById("apply_coupon_btn");
        const discountInfo = document.getElementById("discount_info");

        let productPrice = 999;
        let finalAmount = productPrice;
        let razorpay_order_id = "";
        let selectedCoupon = "";

        commentInput.value = `Payment for order #${productId}`;

        // Step 1: Fetch product and generate initial order
        fetch(`${BASE_URL}/get_products/${productId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${authToken}`
            }
        })
        .then(res => res.json())
        .then(result => {
            if (result.success && result.data) {
                const product = result.data;
                productNameEl.textContent = product.product_name || "Product";
                const imageUrl = product.image?.[0] || "uploads/placeholder.png";
                productImageBox.innerHTML = `<img src="${imageUrl}" alt="Product Image">`;

                // Generate order without coupon
                return generateRazorpayOrder(productPrice);
            } else {
                throw new Error("Product not found");
            }
        })
        .catch(err => {
            console.error("Error:", err);
            alert("Something went wrong while loading product or payment details.");
        });

        // Step 2: Fetch and populate coupons
        fetch(`${BASE_URL}/coupon/index`, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${authToken}`
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                data.data
                    .filter(coupon => coupon.is_active === "1")
                    .forEach(coupon => {
                        const option = document.createElement("option");
                        option.value = JSON.stringify({ name: coupon.name, value: parseFloat(coupon.value) });
                        option.textContent = `${coupon.name} (for ₹${coupon.value} OFF)`;
                        couponSelect.appendChild(option);
                    });
            }
        });

        // Step 3: Apply Coupon
        applyCouponBtn.addEventListener("click", function () {
            const selected = couponSelect.value;
            if (!selected) {
                alert("Please select a valid coupon.");
                return;
            }

            const couponObj = JSON.parse(selected);
            selectedCoupon = couponObj.name;

            discountInfo.style.display = "block";
            discountInfo.textContent = `Coupon applied: ₹${couponObj.value} OFF`;

            // Lock the UI
            couponSelect.disabled = true;
            applyCouponBtn.disabled = true;

            const lockNote = document.createElement("p");
            lockNote.className = "text-muted small mt-1";
            // lockNote.textContent = "Coupon has been applied and locked.";
            discountInfo.parentNode.appendChild(lockNote);

            // Generate new Razorpay order with coupon
            generateRazorpayOrder(productPrice, selectedCoupon).then(() => {
                document.querySelector(".downbox h2").textContent = `Total: ₹${finalAmount}`;
            });
        });

        // Step 4: Razorpay Payment Trigger
        makePaymentBtn.addEventListener("click", function () {
            if (!razorpay_order_id) {
                return alert("Payment not ready yet. Please wait...");
            }

            const options = {
                key: "rzp_test_EVVF2DggZF1FTZ", // replace with your live/test key
                amount: finalAmount * 100,
                currency: "INR",
                name: "Stockout India",
                description: "Product Purchase",
                image: "../uploads/stockout_logo.png",
                order_id: razorpay_order_id,
                handler: function (response) {
                    const razorpay_payment_id = response.razorpay_payment_id;

                    fetch(`${BASE_URL}/store_payment`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": `Bearer ${authToken}`
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: razorpay_payment_id,
                            product: Number(productId)
                        })
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            window.location.href = "pages/account.php";
                        } else {
                            alert("Error storing payment: " + result.message);
                        }
                    })
                    .catch(error => {
                        console.error("Store payment error:", error);
                        alert("Something went wrong while storing the payment.");
                    });
                },
                prefill: {
                    name: "",
                    email: "",
                    contact: ""
                },
                theme: {
                    color: "#b30000"
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        });

        // Step 5: Helper to generate Razorpay Order
        function generateRazorpayOrder(amount, coupon = "") {
            return fetch(`${BASE_URL}/make_payment`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${authToken}`
                },
                body: JSON.stringify({
                    payment_amount: amount,
                    product: Number(productId),
                    coupon: coupon || undefined,
                    comments: commentInput.value
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    razorpay_order_id = data.data.razorpay_order_id;
                    finalAmount = data.data.payment_amount; // ✅ use exact final value from server
                } else {
                    alert("Failed to create payment order: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error in Razorpay order generation:", error);
                alert("Failed to generate Razorpay order.");
            });
        }
    });
</script> -->

<?php include("../footer.php") ?>