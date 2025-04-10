<?php include("header.php") ?>
<?php include("configs/config_static_data.php"); ?> 
<!-- Home Pages -->
        <main class="main index_page">

            <?php include("inc_files/slider_section.php"); ?>

            <section class="popular-products">
                <div class="container">
                    <h2 class="section-title appear-animate" data-animation-name="fadeInUpShorter"
                        data-animation-delay="200">Most Popular Products</h2>

                        <div class="container py-4">
                            <div id="product-container" class="row gy-4">

                            </div>
                            <div class="view_more">
                                <a href="all-products.php text-primary">View More</a>
                            </div>
                        </div>

                        
                    <div class="categories-slider owl-carousel owl-theme mb-4 appear-animate" data-owl-options="{
                                'margin': 2,
                                'nav': false,
                                'items': 1,
                                'responsive': {
                                    '992': {
                                        'items': 4
                                    },
                                    '1200': {
                                        'items': 5
                                    }
                                }
                            }" data-animation-name="fadeInUpShorter" data-animation-delay="200">
                        <div class="product-category">
                            <img src="assets/images/demoes/demo27/icons/icon-1.png" alt="icon" width="60" height="60">
                            <div class="category-content">
                                <h3 class="font2 ls-0 text-uppercase mb-0">Bike Saddles</h3>
                            </div>
                        </div>
                        <div class="product-category">
                            <img src="assets/images/demoes/demo27/icons/icon-2.png" alt="icon" width="60" height="60">
                            <div class="category-content">
                                <h3 class="font2 ls-0 text-uppercase mb-0">Bike Pedals</h3>
                            </div>
                        </div>
                        <div class="product-category">
                            <img src="assets/images/demoes/demo27/icons/icon-3.png" alt="icon" width="60" height="60">
                            <div class="category-content">
                                <h3 class="font2 ls-0 text-uppercase mb-0">Bike Frames</h3>
                            </div>
                        </div>
                        <div class="product-category">
                            <img src="assets/images/demoes/demo27/icons/icon-4.png" alt="icon" width="60" height="60">
                            <div class="category-content">
                                <h3 class="font2 ls-0 text-uppercase mb-0">Bike Chains</h3>
                            </div>
                        </div>
                        <div class="product-category">
                            <img src="assets/images/demoes/demo27/icons/icon-5.png" alt="icon" width="60" height="60">
                            <div class="category-content">
                                <h3 class="font2 ls-0 text-uppercase mb-0">Bike Tools</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="banners-section mb-4">
                <div class="row row-sm">
                    <div class="col-md-4">
                        <div class="banner banner1 appear-animate" data-animation-name="fadeIn"
                            data-animation-delay="200" style="background-color: #696f6f;">
                            <figure>
                                <img src="uploads/banner/banner1.jpg" alt="banner" width="640"
                                    height="640">
                            </figure>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="banner banner2 h-100" style="background: #101010 no-repeat center/cover url(uploads/banner/banner2.jpg);">
                            <!-- <h4 class="text-light text-uppercase mb-0 appear-animate"
                                data-animation-name="fadeInUpShorter" data-animation-delay="100">Get Ready</h4>
                            <h2 class="d-inline-block align-middle text-uppercase m-b-3 appear-animate"
                                data-animation-name="fadeInUpShorter" data-animation-delay="300">20% off</h2><a
                                href="demo27-shop.html"
                                class="btn btn-dark btn-lg align-middle m-b-3 appear-animate d-none d-sm-inline-block"
                                data-animation-name="fadeInUpShorter" data-animation-delay="300">Shop All Sale</a>
                            <h3 class="heading-border appear-animate" data-animation-name="fadeInUpShorter"
                                data-animation-delay="500">BIKES</h3> -->
                        </div>
                    </div>
                </div>
            </div>

            <section class="trendy-section mb-2">
                <div class="container">
                    <h2 class="section-title appear-animate" data-animation-name="fadeInUpShorter"
                        data-animation-delay="200">Trending Accessories</h2>

                    <div class="row appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">
                        <div class="products-slider 5col owl-carousel owl-theme" data-owl-options="{
                            'margin': 0
                        }">
                            <div class="product-default">
                                <figure>
                                    <a href="demo27-product.html">
                                        <img src="assets/images//demoes/demo27/products/product-2.jpg" width="280"
                                            height="280" alt="product">
                                    </a>
                                    <div class="label-group">
                                        <div class="product-label label-hot">HOT</div>
                                        <div class="product-label label-sale">-13%</div>
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="category-list">
                                        <a href="category.html" class="product-category">Category</a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="demo27-product.html">Porto Fashion Bike</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                        <span class="old-price">$299.0</span>
                                        <span class="product-price">$259.0</span>
                                    </div><!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i
                                                class="icon-heart"></i></a>
                                        <a href="demo27-product.html"
                                            class="btn-icon btn-add-cart product-type-simple"><i
                                                class="icon-shopping-cart"></i><span>ADD TO CART</span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div><!-- End .product-details -->
                            </div>
                            <div class="product-default">
                                <figure>
                                    <a href="demo27-product.html">
                                        <img src="assets/images//demoes/demo27/products/product-7.jpg" width="280"
                                            height="280" alt="product">
                                    </a>
                                    <div class="label-group">
                                        <div class="product-label label-hot">HOT</div>
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="category-list">
                                        <a href="category.html" class="product-category">Category</a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="demo27-product.html">Bike Kit</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                        <span class="product-price">$55.0</span>
                                    </div><!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i
                                                class="icon-heart"></i></a>
                                        <a href="demo27-product.html"
                                            class="btn-icon btn-add-cart product-type-simple"><i
                                                class="icon-shopping-cart"></i><span>ADD TO CART</span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div><!-- End .product-details -->
                            </div>
                            <div class="product-default">
                                <figure>
                                    <a href="demo27-product.html">
                                        <img src="assets/images//demoes/demo27/products/product-8.jpg" width="280"
                                            height="280" alt="product">
                                    </a>
                                    <div class="label-group">
                                        <div class="product-label label-sale">-17%</div>
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="category-list">
                                        <a href="category.html" class="product-category">Category</a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="demo27-product.html">Bike Glasses</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:0%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                        <span class="old-price">$59.0</span>
                                        <span class="product-price">$49.0</span>
                                    </div><!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i
                                                class="icon-heart"></i></a>
                                        <a href="demo27-product.html"
                                            class="btn-icon btn-add-cart product-type-simple"><i
                                                class="icon-shopping-cart"></i><span>ADD TO CART</span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div><!-- End .product-details -->
                            </div>
                            <div class="product-default">
                                <figure>
                                    <a href="demo27-product.html">
                                        <img src="assets/images//demoes/demo27/products/product-9.jpg" width="280"
                                            height="280" alt="product">
                                    </a>
                                    <div class="label-group">
                                        <div class="product-label label-hot">HOT</div>
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="category-list">
                                        <a href="category.html" class="product-category">Category</a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="demo27-product.html">Bike Frames</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:60%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                        <span class="product-price">$599.0</span>
                                    </div><!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i
                                                class="icon-heart"></i></a>
                                        <a href="demo27-product.html" class="btn-icon btn-add-cart"><i
                                                class="fa fa-arrow-right"></i><span>SELECT OPTIONS</span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div><!-- End .product-details -->
                            </div>
                            <div class="product-default">
                                <figure>
                                    <a href="demo27-product.html">
                                        <img src="assets/images//demoes/demo27/products/product-10.jpg" width="280"
                                            height="280" alt="product">
                                    </a>
                                </figure>
                                <div class="product-details">
                                    <div class="category-list">
                                        <a href="category.html" class="product-category">Category</a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="demo27-product.html">Bike Chain</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                        <span class="product-price">$39.0</span>
                                    </div><!-- End .price-box -->
                                    <div class="product-action">
                                        <a href="wishlist.html" class="btn-icon-wish" title="wishlist"><i
                                                class="icon-heart"></i></a>
                                        <a href="demo27-product.html" class="btn-icon btn-add-cart"><i
                                                class="fa fa-arrow-right"></i><span>SELECT OPTIONS</span></a>
                                        <a href="ajax/product-quick-view.html" class="btn-quickview"
                                            title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </div><!-- End .product-details -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-2">
                            <div class="banner banner3 d-flex flex-wrap align-items-center bg-gray h-100 appear-animate"
                                data-animation-name="fadeInRightShorter" data-animation-delay="100">
                                <div class="col-sm-4 text-center">
                                    <h3 class="font5 mb-0">Summer Sale</h3>
                                    <h2 class="text-uppercase mb-0">20% off</h2>
                                </div>
                                <div class="col-sm-4">
                                    <img src="assets/images/demoes/demo27/banners/banner-3.jpg" alt="banner" width="232"
                                        height="124">
                                </div>
                                <div class="col-sm-4 text-center">
                                    <a href="demo27-shop.html" class="btn btn-dark">Shop All Sale</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 mb-2">
                            <div class="banner banner4 d-flex flex-wrap align-items-center bg-primary h-100 appear-animate"
                                data-animation-name="fadeInRightShorter" data-animation-delay="400">
                                <div class="col-sm-4 text-center">
                                    <h3 class="font5 text-white mb-0">Flash Sale</h3>
                                    <h2 class="text-uppercase text-white mb-0">30% off</h2>
                                </div>
                                <div class="col-sm-4">
                                    <img src="assets/images/demoes/demo27/banners/banner-4.jpg" alt="banner" width="232"
                                        height="124">
                                </div>
                                <div class="col-sm-4 text-center">
                                    <a href="demo27-shop.html" class="btn btn-light">Shop All Sale</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
<!-- End Home Pages -->
       
<script>
    const apiUrl = `<?php echo BASE_URL; ?>/get_products`;
    const token = localStorage.getItem("authtoken");
    // const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

    async function fetchProducts() {
        // const token = localStorage.getItem("authtoken");
        const token = '100|MLh8ulMfLjjkcHPsUZ9WVI9xRb9B41oOdtm6cFOyed6e6744';

    const headers = {
      "Content-Type": "application/json"
    };
    if (token) {
      headers["Authorization"] = `Bearer ${token}`;
    }

    const response = await fetch("<?php echo BASE_URL; ?>/get_products", {
      method: "POST",
      headers: headers
    });

    const result = await response.json();

    if (result.success) {
      renderProducts(result.data.slice(0, 10)); // Only show first 15
    } else {
      alert("Failed to fetch products");
    }
  }

  function renderProducts(products) {
    const container = document.getElementById("product-container");
    container.innerHTML = ""; // Clear existing cards

    products.forEach((product, index) => {
      if (index % 4 === 0) {
        container.innerHTML += `<div class="w-100"></div>`; // line break for new row
      }

      const image = product.image?.[0] || "uploads/placeholder.png";
      const card = `
        <div class="col-12 col-sm-6 col-md-3 d-flex justify-content-center">
          <div class="product-card bg-white">
            <span class="badge bg-danger text-white position-absolute top-0 start-0 mt-1 m-2 px-2 py-2 rounded-pill badge-featured">Featured</span>
            <div class="position-absolute top-0 end-0 m-2 d-flex flex-column gap-4 card_side_icon">
              <i class="fa-regular fa-heart text-danger" style="cursor: pointer;"></i>
              <i class="fa-solid fa-share text-danger" style="cursor: pointer;"></i>
            </div>
            <div class="image_box">
                <img src="${image}" class="card-img-top img-fluid" alt="${product.product_name}">
            </div>
            <hr class="my-0">
            <div class="card-body pt-2 pb-1 px-3">                
                <div class="left_side_body">
                    <h6 class="text-success fw-bold">${product.product_name}</h6>
                    <p class="p_user fw-semibold mb0">Dealer: ${product.user?.name || "N/A"}</p>
                    <p class="p_price fw-bold text-danger mb0" style="font-size: 1.1rem;">₹${product.selling_price}/${product.unit}</p>
                </div>
                <div class="right_side_body">
                    <span class="badge bg-secondary text-white">Qty: <strong>${product.offer_quantity}</strong></span>
                    <span class="badge bg-warning text-dark">Min: <strong>${product.minimum_quantity}</strong></span>
                </div>
            </div>
            <div class="d-flex bottom-btns index_page_card">
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
      container.innerHTML += card;
    });
  }

  fetchProducts(); // Call on page load
</script>
<?php include("footer.php") ?>