<base href="../">
<?php include("../header.php") ?>
<?php include("../configs/config_static_data.php"); ?> 
<?php include("../configs/auth_check.php"); ?>
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
                    <button id="tab-configurations" class="acc-btn" onclick="showAccTab('configurations')">
                      <i class="fas fa-user-circle"></i>
                      Configurations
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

                    <div id="acc-configurationsTab" class="acc-tab-content">
                        <h3>Configure Your Datas</h3>
                    </div>
                </div>
            </section>

		</main><!-- End .main -->
<script>
//   function showAccTab(tabId) {
//     document.querySelectorAll('.acc-tab-content').forEach(tab => tab.classList.remove('acc-active'));
//     document.getElementById('acc-' + tabId + 'Tab').classList.add('acc-active');
//   }
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
</script>

<script>
  // Auto-fill inputs from localStorage on page load
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('name').value = localStorage.getItem('name') || '';
    document.getElementById('id').value = localStorage.getItem('user_id') || '';
    document.getElementById('role').value = localStorage.getItem('role') || '';
    document.getElementById('username').value = localStorage.getItem('username') || '';
    document.getElementById('token').value = localStorage.getItem('token') || '';
  });

  // Update localStorage from input values
  function updateAccountInfo() {
    localStorage.setItem('name', document.getElementById('name').value);
    localStorage.setItem('id', document.getElementById('user_id').value);
    localStorage.setItem('role', document.getElementById('role').value);
    localStorage.setItem('username', document.getElementById('username').value);
    localStorage.setItem('token', document.getElementById('token').value);
    alert('Account information updated successfully!');
  }
</script>
<?php include("../footer.php") ?>