<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                    </ol>
                </div>
            </nav>

            <div class="container">
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 product-single-gallery">
                            <div class="product-slider-container">
                                <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                    <div class="product-item product_page">
                                        <img class="product-single_image"
                                            src=""
                                            width="468" height="468" alt="product" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-6 product-single-details">
                            <h1 class="product-title">...</h1>

                            <hr class="short-divider">

                            <div class="price-box">
                                <del class="old-price"><span>₹0.00</span></del>
                                <span class="product-price">₹0.00</span>
                            </div>

                            <div class="product-desc">
                                <p>Loading description...</p>
                            </div>

                            <ul class="single-info-list">
                                <li>
                                    SKU: <strong>Loading...</strong>
                                </li>
                            </ul>

                            <div class="product-action mt-3">
                                <div class="product-single-qty">
                                    <input class="horizontal-quantity form-control" type="text" value="1">
                                </div>
                                <a href="javascript:;" class="btn btn-dark add-cart mr-2" title="Add to Cart">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- End .container -->
        </main><!-- End .main -->
<!-- ✅ SCRIPT SECTION -->
<script>
    const BASE = "<?php echo BASE_URL; ?>";

    // Get ?name=ProductName from URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    async function loadProductDetails() {
        const productName = getQueryParam('name');
        if (!productName) {
            alert("Product not found!");
            return;
        }

        const token = localStorage.getItem('authToken');
        const payload = { search: productName };

        try {
            const res = await fetch(`${BASE}/product/get_products`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    ...(token && { Authorization: `Bearer ${token}` })
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (!data.success || !Array.isArray(data.data)) {
                alert("Unable to load product.");
                return;
            }

            const product = data.data.find(p => p.product_name === productName);
            if (!product) {
                alert("Product not found.");
                return;
            }

            renderProduct(product);
        } catch (error) {
            console.error("Fetch error:", error);
        }
    }

    function renderProduct(product) {
        document.querySelector(".product-title").innerText = product.product_name;
        document.querySelector(".product-single_image").src = product.image?.[0] || "uploads/placeholder.png";
        // document.querySelector(".product-single-image").setAttribute("data-zoom-image", product.image?.[0] || "uploads/placeholder.png");
        document.querySelector(".product-price").innerText = `₹${product.selling_price}`;
        document.querySelector(".old-price span").innerText = `₹${product.original_price}`;
        document.querySelector(".product-desc p").innerText = product.description || "No description available.";
        document.querySelector(".single-info-list strong").innerText = product.id || "N/A";
    }

    document.addEventListener("DOMContentLoaded", loadProductDetails);
</script>

<?php include("../footer.php") ?>