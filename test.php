<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Cards</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    .product-card {
      width: 220px;
      font-family: sans-serif;
      position: relative;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin: 1rem;
    }
    .product-card img {
      padding: 1rem;
    }
    .product-card hr {
      margin: 0;
    }
    .badge-featured {
      font-size: 12px;
    }
    .bottom-btns button {
      font-size: 1.2rem;
      padding: 0.6rem 0;
    }
  </style>
</head>
<body>

  <div class="container py-4">
    <div class="row" id="product-container">
      <!-- Product cards will be injected here -->
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Sample JSON data
    const products = [
      {
        name: "Safety Jacket",
        image: "https://via.placeholder.com/200x200.png?text=Safety+Jacket",
        quantity: 200,
        min_qty: 50,
        dealer: "Saif Inc",
        location: "Hyderabad",
        price: "42.5"
      },
      {
        name: "Safety Helmet",
        image: "https://via.placeholder.com/200x200.png?text=Helmet",
        quantity: 150,
        min_qty: 20,
        dealer: "Max Safety",
        location: "Mumbai",
        price: "85.0"
      },
      {
        name: "Safety Gloves",
        image: "https://via.placeholder.com/200x200.png?text=Gloves",
        quantity: 300,
        min_qty: 100,
        dealer: "SecureTech",
        location: "Delhi",
        price: "22.5"
      },
      {
        name: "Reflective Tape",
        image: "https://via.placeholder.com/200x200.png?text=Reflective+Tape",
        quantity: 500,
        min_qty: 100,
        dealer: "BrightMark",
        location: "Chennai",
        price: "15.0"
      },
      {
        name: "Safety Boots",
        image: "https://via.placeholder.com/200x200.png?text=Boots",
        quantity: 100,
        min_qty: 10,
        dealer: "SteelGuard",
        location: "Ahmedabad",
        price: "299.0"
      }
    ];

    const container = document.getElementById("product-container");

    products.forEach(product => {
      container.innerHTML += `
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="product-card bg-white">
            <span class="badge bg-danger text-white position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill badge-featured">Featured</span>

            <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-2">
              <i class="fa-regular fa-heart text-danger" style="cursor: pointer;"></i>
              <i class="fa-solid fa-share text-danger" style="cursor: pointer;"></i>
            </div>

            <img src="${product.image}" class="card-img-top img-fluid" alt="${product.name}">

            <hr class="my-0">

            <div class="card-body pt-2 pb-1 px-3">
              <h6 class="text-success fw-bold mb-1">${product.name}</h6>

              <div class="d-flex justify-content-between small">
                <span class="badge bg-secondary text-white">Quantity : <strong>${product.quantity}</strong></span>
                <span class="badge bg-warning text-dark">Min Qty : <strong>${product.min_qty}</strong></span>
              </div>

              <p class="small text-danger fw-semibold mt-2 mb-1">Dealer Name : ${product.dealer}</p>

              <div class="d-flex align-items-center small text-muted mb-2">
                <i class="fa-solid fa-location-dot me-1"></i> ${product.location}
              </div>

              <p class="fw-bold text-danger mb-2" style="font-size: 1.1rem;">Price: ₹${product.price}/pc</p>
            </div>

            <div class="d-flex bottom-btns">
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
    });
  </script>

</body>
</html>
