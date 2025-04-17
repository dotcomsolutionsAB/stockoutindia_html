<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockout India Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="custom/admin_style.css">
</head>
<body class="bg-gray-50">

    <div class="flex h-screen">
        
        <!-- Sidebar for larger screens -->
        <?php include("admin_inc/admin_sidebar.php"); ?>

        <!-- Main Content -->
        <div class="flex-1 p-1 overflow-y-auto">

            <!-- Navbar for larger screens -->
            <?php include("admin_inc/admin_nav.php"); ?>

            <!-- Content Sections -->
            <div class="main_content p-3">
                <!-- Profile Section -->
                <?php include("admin_inc/admin_profile_section.php"); ?>

                <!-- View Products Section -->
                <?php include("admin_inc/admin_product_section.php"); ?>                

                <!-- View Users Section -->
                <?php include("admin_inc/admin_users_section.php"); ?> 
                
                <!-- Orders Section -->
                <?php include("admin_inc/admin_orders_section.php"); ?>                

                <!-- Order History Section -->
                <div id="order-history" class="tab-content">
                    <h2 class="text-2xl font-semibold text-red-600 mb-6">Order History</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <!-- Order Card -->
                        <div class="card bg-white p-4 rounded-lg shadow-md">
                            <img src="https://via.placeholder.com/150" alt="Order Image" class="w-full h-32 object-cover mb-4 rounded-md">
                            <p class="text-sm text-gray-600">Order ID: order_QlqgpoCB2UvusG</p>
                            <p class="text-lg font-semibold text-gray-900">Amount: ₹500</p>
                            <p class="text-sm text-gray-600">Status: created</p>
                            <p class="text-sm text-gray-600">Date: 2025-04-14</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show the selected tab content
        function showTab(tabName) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => {
                tab.classList.remove('active');
            });

            const selectedTab = document.getElementById(tabName);
            selectedTab.classList.add('active');

            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            const selectedButton = document.querySelector(`[onclick="showTab('${tabName}')"]`);
            selectedButton.classList.add('active');
        }

        // Toggle the sidebar visibility on hamburger click
        const hamburger = document.getElementById("hamburger");
        const sidebar = document.querySelector(".bg-red-900");
        const closeHamburger = document.getElementById("closeHam");
        // closeHamburger.addEventListener("click", function() {
        //     sidebar.classList.toggle("hidden");
        // });
        hamburger.addEventListener("click", function() {
            sidebar.classList.toggle("hidden");
        });

        // Toggle the visibility of the dropdown menu when clicking the profile button
        const profileButton = document.getElementById("profileButton");
        const dropdownContent = document.getElementById("dropdownContent");

        profileButton.addEventListener("click", function() {
            dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
        });

        // Close the dropdown if clicked outside the profile button
        window.addEventListener("click", function(event) {
            if (!profileButton.contains(event.target)) {
                dropdownContent.style.display = "none";
            }
        });
    </script>
</body>
</html>
