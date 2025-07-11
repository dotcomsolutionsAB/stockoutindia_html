<section class="payment_section">
  <h2 class="payment_title">Order History</h2>
  <div id="payment_container" class="payment_container">
    <!-- Dynamic payment cards will be inserted here -->
  </div>
</section>
<script>
    const BASES_URL = "https://api.stockoutindia.com/api";
    const user_id = localStorage.getItem("user_id");
    const authTokens = localStorage.getItem("authToken");

    async function loadPayments() {
    const container = document.getElementById("payment_container");
    container.innerHTML = "Loading...";

    try {
        const res = await fetch(`${BASES_URL}/fetch_payment`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${authTokens}`
        },
        body: JSON.stringify({ user: user_id })
        });

        const response = await res.json();

        if (response.success && Array.isArray(response.data)) {
        container.innerHTML = "";

        response.data.forEach(payment => {
            const { razorpay_order_id, payment_amount, status, date } = payment;

            const card = document.createElement("div");
            card.className = "payment_card";

            card.innerHTML = `
            <div class="div_img">
                <img src="uploads/placeholder.png" alt="Product" class="payment_image">
            </div>
            <div class="payment_details">
                <h4 class="payment_order">Order ID: ${razorpay_order_id}</h4>
                <p class="payment_amount">Amount: ₹${payment_amount}</p>
                <p class="payment_status">Status: 
                <span class="payment_status_tag success">${status}</span>
                </p>
                <p class="payment_date">Date: ${date}</p>
            </div>
            `;

            container.appendChild(card);
        });

        } else {
        container.innerHTML = "<p>No payments found.</p>";
        }

    } catch (err) {
        console.error(err);
        container.innerHTML = "<p>Error loading payments.</p>";
    }
    }

    document.addEventListener("DOMContentLoaded", loadPayments);
</script>
