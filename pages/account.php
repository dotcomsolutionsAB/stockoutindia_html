<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 

		<main class="main">
          <section class="account_page">
              <div class="acc-sidebar">
                  <h2 class="acc-title">Account</h2>
                  <button id="tab-profile" class="acc-btn" onclick="showAccTab('profile')">
                    <i class="fas fa-user-circle"></i>
                    Profile
                  </button>
                  <button id="tab-products" class="acc-btn" onclick="showAccTab('products')">
                    <i class="fas fa-boxes"></i>
                    My Products
                  </button>
                  <button id="tab-addProducts" class="acc-btn" onclick="showAccTab('addProducts')">
                    <i class="fas fa-plus-circle"></i>
                    Add Products
                  </button>
                  <button id="tab-wishlist" class="acc-btn" onclick="showAccTab('wishlist')">
                    <i class="fa-regular fa-heart"></i>
                    Wisthlist
                  </button>
                  <button id="tab-orderHistory" class="acc-btn" onclick="showAccTab('orderHistory')">
                    <i class="fas fa-user-circle"></i>
                    Order History
                  </button>
                  <button class="acc-btn acc-logout" onclick="accLogout()">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                  </button>
              </div>

              <div class="acc-main">
                  <div id="acc-profileTab" class="acc-tab-content acc-active">
                      <?php include("profile_section.php"); ?>
                  </div>

                  <div id="acc-productsTab" class="acc-tab-content">
                      <?php include("my-product_section.php"); ?>
                  </div>

                  <div id="acc-addProductsTab" class="acc-tab-content">
                      <?php include("add-product_section.php"); ?>
                  </div>

                  <div id="acc-wishlistTab" class="acc-tab-content">
                      <?php include("wishlist_section.php"); ?>
                  </div>

                  <div id="acc-orderHistoryTab" class="acc-tab-content">
                      <?php include("order_history_section.php"); ?>
                  </div>
              </div>
          </section>
		</main>


<script>
    function showAccTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.acc-tab-content')
                .forEach(tab => tab.classList.remove('acc-active'));
        document.getElementById('acc-' + tabId + 'Tab')
                .classList.add('acc-active');

        // Button states
        document.querySelectorAll('.acc-btn')
                .forEach(btn => btn.classList.remove('acc-tab-active'));
        document.getElementById('tab-' + tabId)
                .classList.add('acc-tab-active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        // read ?tab=… from the URL
        const params      = new URLSearchParams(window.location.search);
        const requested   = params.get('tab');            // e.g. "wishlist"
        const validTabs   = ['profile','products','addProducts','wishlist','orderHistory'];

        // Fall back to “products” if no / bad value
        const initialTab = (requested && validTabs.includes(requested))
                           ? requested
                           : 'products';

        showAccTab(initialTab);
    });

    function accLogout() {
        localStorage.removeItem("authToken");
        localStorage.removeItem("user_id");
        localStorage.removeItem("role");
        localStorage.removeItem("username");
        localStorage.removeItem("name");
        window.location.href = "login";
    }
</script>


<?php include("../footer.php") ?>

