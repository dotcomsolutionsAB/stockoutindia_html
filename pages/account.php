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

<!-- <script>
    function showAccTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.acc-tab-content').forEach(tab => tab.classList.remove('acc-active'));
        document.getElementById('acc-' + tabId + 'Tab').classList.add('acc-active');

        // Remove active styling from all buttons
        document.querySelectorAll('.acc-btn').forEach(btn => btn.classList.remove('acc-tab-active'));

        // Add active styling to clicked tab
        document.getElementById('tab-' + tabId).classList.add('acc-tab-active');
    }
    // Set default tab on load
    document.addEventListener("DOMContentLoaded", function () {
        showAccTab('products');
    });
  function accLogout() {
    localStorage.removeItem("authToken");
    localStorage.removeItem("user_id");
    localStorage.removeItem("role");
    localStorage.removeItem("username");
    localStorage.removeItem("name");

    window.location.href = "login.php";
  }
</script> -->
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
        window.location.href = "login.php";
    }
</script>


<?php include("../footer.php") ?>

<!-- <style>
    /* ─── 1.  Desktop (unchanged) ─────────────────────────────────── */
  @media (min-width: 768px) {
    .account_page {
      display: flex;                   /* sidebar + main side-by-side */
      gap: 24px;
    }

    .acc-sidebar {                     /* keep your current sidebar width */
      width: 240px;
      flex-shrink: 0;
    }
  }

  /* ─── 2.  Mobile (≤ 767 px)  ──────────────────────────────────── */
  @media (max-width: 767px) {
    /* Make the page flow vertically */
    .account_page {
      display: block;
    }

    /* Turn the sidebar into a sticky horizontal bar */
    .acc-sidebar {
      position: sticky;
      width: 100%;
      top: 0;
      z-index: 20;
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 6px 0;
      background: #fff;                /* matches theme */
      border-bottom: 1px solid #ececec;
      overflow-x: auto;                /* scroll if icons overflow */
      scrollbar-width: none;           /* hide scrollbar in Firefox */
      gap: 7px;
    }
    .acc-sidebar::-webkit-scrollbar { display: none; } /* hide in Chrome */

    /* Individual buttons – shrink to icon only */
    .acc-btn {
      flex: 0 0 48px;                  /* equal-width buttons */
      height: 48px;
      padding: 0;
      font-size: 0;                    /* hides the text label */
      border: none;
      background: transparent;
      transition: background 0.2s;
      background: antiquewhite;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .acc-btn i {
      font-size: 22px;                 /* icon size */
    }

    /* Active tab highlight */
    .acc-tab-active,
    .acc-btn:focus-visible {
      background: #be1312;
      border-radius: 6px;
    }

    /* OPTIONAL: Still expose the label to screen readers */
    .acc-btn::after {
      content: attr(aria-label);
      position: absolute;
      left: -9999px;
    }
  }

  /* ─── 3.  General tweaks ──────────────────────────────────────── */
  .acc-btn { cursor: pointer; }

</style> -->