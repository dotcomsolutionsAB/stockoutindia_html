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
            
                <button id="makePaymentBtn" class="make_payment_button">Make Payment</button>
            </div>
        </section>
    </div><!-- End .container -->
</main>
<style>

</style>

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
</script>

<?php include("../footer.php") ?>