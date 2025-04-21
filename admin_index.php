<!-- <base href="../"> -->
<?php include("configs/config_static_data.php"); ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockout India Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const token = localStorage.getItem('authToken');
        const role = localStorage.getItem('role');

        if (!token || role !== 'admin') {
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: 'This page is for Admins only.',
                confirmButtonColor: '#d33',
                }).then(() => {
                window.location.href = "login.php";
            });
        }
    </script>

    <!-- <script>
        const token = localStorage.getItem('authToken');
        const role = localStorage.getItem('role');
        if (!token || role !== 'admin') {
            alert("Admin access only.");
            window.location.href = "login.php";
        }
    </script> -->
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
    <!-- <script src="configs/auth.js"></script> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
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

                <!-- View all Products Section -->
                <?php include("admin_inc/view_all_product_section.php"); ?>  
                
                <!-- View Product by user Section -->
                <?php include("admin_inc/view_product_by_user_section.php"); ?> 

                <!-- View order by users Section -->
                <?php include("admin_inc/view_order_by_users_section.php"); ?>                

                <!-- Settings Section -->
                <?php include("admin_inc/setting_section.php"); ?> 
                
                <!-- Test Section -->
                <?php include("admin_inc/admin_test_section.php"); ?>   
                
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
