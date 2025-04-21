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
                <div class="coupon_section mb-4">
                    <label for="coupon_select" class="fw-semibold text-dark mb-1 d-block">Apply Coupon:</label>
                    <div class="d-flex gap-2">
                        <select id="coupon_select" class="form-select" style="flex: 1;">
                            <option value="">-- Select Coupon --</option>
                        </select>
                        <button id="apply_coupon_btn" class="btn btn-sm btn-outline-success">Apply</button>
                    </div>
                    <p id="discount_info" class="text-success mt-2 fw-semibold" style="display: none;"></p>
                </div>

                <button id="makePaymentBtn" class="make_payment_button">Make Payment</button>
            </div>
        </section>
    </div><!-- End .container -->
</main>
<style>

</style>
<!-- <script>
    // Coupon-related elements
    const couponSelect = document.getElementById("coupon_select");
    const applyCouponBtn = document.getElementById("apply_coupon_btn");
    const discountInfo = document.getElementById("discount_info");
    let appliedCouponValue = 0;

    // Fetch and populate coupons
    fetch(`<?php echo BASE_URL; ?>/coupon/index`, {
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
                    option.value = coupon.value;
                    option.textContent = `${coupon.name} (for ₹${coupon.value} OFF)`;
                    couponSelect.appendChild(option);
                });
        }
    });

    // Apply coupon logic
    applyCouponBtn.addEventListener("click", function () {
        const selectedValue = parseFloat(couponSelect.value);
        if (!selectedValue) {
            alert("Please select a valid coupon.");
            return;
        }

        appliedCouponValue = selectedValue;
        const discountedPrice = productPrice - appliedCouponValue;
        document.querySelector(".downbox h2").textContent = `Total: ₹${discountedPrice}`;
        discountInfo.style.display = "block";
        discountInfo.textContent = `Coupon applied successfully! ₹${appliedCouponValue} OFF`;
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const authToken = localStorage.getItem("authToken");
        const BASE_URL = "{{base_url}}";

        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get("product_id");

        const productNameEl = document.getElementById("product_name");
        const productImageBox = document.getElementById("product_image_box");
        const commentInput = document.getElementById("comment_input");
        const makePaymentBtn = document.getElementById("makePaymentBtn");

        let razorpay_order_id = "";
        let productPrice = 999;

        commentInput.value = `Payment for order #${productId}`;

        // Step 1: Fetch product details
        fetch(`<?php echo BASE_URL; ?>/get_products/${productId}`, {
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

            // Step 2: Immediately call make_payment to get razorpay_order_id
            return fetch(`<?php echo BASE_URL; ?>/make_payment`, {
                method: "POST",
                headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${authToken}`
                },
                body: JSON.stringify({
                payment_amount: productPrice,
                product: Number(productId),
                comments: commentInput.value
                })
            });
            } else {
            throw new Error("Product not found");
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data) {
            razorpay_order_id = data.data.razorpay_order_id;
            productPrice = data.data.payment_amount;
            } else {
            alert("Failed to initiate payment: " + data.message);
            }
        })
        .catch(err => {
            console.error("Error:", err);
            alert("Something went wrong while loading payment details.");
        });   

        // Step 3: Trigger Razorpay popup
        makePaymentBtn.addEventListener("click", function () {
            if (!razorpay_order_id) {
            return alert("Order not ready yet. Please wait...");
            }

            const options = {
            key: "rzp_test_EVVF2DggZF1FTZ", // 🔁 replace with your live/test Razorpay key
            amount: productPrice * 100, // Razorpay expects amount in paise
            currency: "INR",
            name: "Stockout India",
            description: "Product Purchase",
            image: "../uploads/stockout_logo.png", // optional logo
            order_id: razorpay_order_id,
            handler: function (response) {
                // Step 1: Extract payment ID
                const razorpay_payment_id = response.razorpay_payment_id;

                // Step 2: Send to /store_payment
                fetch(`<?php echo BASE_URL; ?>/store_payment`, {
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
                        // alert("Payment stored successfully!");
                        window.location.href = "pages/account.php"; // 🔁 update the path if needed
                        // location.reload(); // ✅ Step 3: Reload page
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
                name: "", // optional
                email: "", // optional
                contact: "" // optional
            },
            theme: {
                color: "#b30000"
            }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        });
    });
</script> -->
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
    const couponSelect = document.getElementById("coupon_select");
    const applyCouponBtn = document.getElementById("apply_coupon_btn");
    const discountInfo = document.getElementById("discount_info");

    let productPrice = 999;
    let finalAmount = productPrice;
    let razorpay_order_id = "";
    let selectedCoupon = "";

    // Prefill comment
    commentInput.value = `Payment for order #${productId}`;

    // Step 1: Fetch product details
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

            // Step 2: Generate default Razorpay order (no coupon)
            return generateRazorpayOrder(productPrice);
        } else {
            throw new Error("Product not found");
        }
    })
    .catch(err => {
        console.error("Error:", err);
        alert("Something went wrong while loading product or payment details.");
    });

    // Step 3: Fetch coupon list
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

    // Apply coupon button handler
    // applyCouponBtn.addEventListener("click", function () {
    //     const selected = couponSelect.value;
    //     if (!selected) {
    //         alert("Please select a valid coupon.");
    //         return;
    //     }

    //     const couponObj = JSON.parse(selected);
    //     selectedCoupon = couponObj.name;
    //     const discount = couponObj.value;
    //     finalAmount = productPrice - discount;

    //     document.querySelector(".downbox h2").textContent = `Total: ₹${finalAmount}`;
    //     discountInfo.style.display = "block";
    //     discountInfo.textContent = `Coupon applied: ₹${discount} OFF`;

    //     // Step 4: Regenerate Razorpay order with coupon
    //     generateRazorpayOrder(finalAmount, selectedCoupon);
    // });
    applyCouponBtn.addEventListener("click", function () {
        const selected = couponSelect.value;
        if (!selected) {
            alert("Please select a valid coupon.");
            return;
        }

        const couponObj = JSON.parse(selected);
        selectedCoupon = couponObj.name;
        const discount = couponObj.value;
        finalAmount = productPrice - discount;

        document.querySelector(".downbox h2").textContent = `Total: ₹${finalAmount}`;
        discountInfo.style.display = "block";
        discountInfo.textContent = `Coupon applied: ₹${discount} OFF`;

        // ✅ Lock the coupon select and disable Apply button
        couponSelect.disabled = true;
        applyCouponBtn.disabled = true;

        // ✅ Show an info note
        const lockNote = document.createElement("p");
        lockNote.className = "text-muted small mt-1";
        lockNote.textContent = "Coupon has been applied and locked.";
        discountInfo.parentNode.appendChild(lockNote);

        // 🔁 Generate Razorpay order with coupon
        generateRazorpayOrder(finalAmount, selectedCoupon);
    });


    // Step 5: Razorpay popup
    makePaymentBtn.addEventListener("click", function () {
        if (!razorpay_order_id) {
            return alert("Payment not ready yet. Please wait...");
        }

        const options = {
            key: "rzp_test_EVVF2DggZF1FTZ", // replace with your actual key
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

    // ✅ Helper: Generate Razorpay order
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

<?php include("../footer.php") ?>