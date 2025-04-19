(function() {
    const token = localStorage.getItem('authToken');
    const role = localStorage.getItem('role');
    const currentPath = window.location.pathname;
    const pageName = currentPath.split("/").pop(); // eg: 'profile.php'
  
    // Pages that require customer access
    const  adminOnlyPages = [
        "admin_index.php", 
        "admin/order-table.php"
    ];
    // Pages that require admin access
    const customerOnlyPages = [
        "pages/account.php" 
        // "../pages/account.php", 
    ];
  
  
    // 🔒 If it's a customer-only page
    if (customerOnlyPages.includes(pageName)) {
        if (!token || role !== 'customer') {
          alert("Login as customer to access this page.");
          window.location.href = "login.php";
          return;
        }else{
            console.log("customer logged in")
        }
      }
    
      // 🔒 If it's an admin-only page
      if (adminOnlyPages.includes(pageName)) {
        if (!token || role !== 'admin') {
          alert("Admin access only.");
          window.location.href = "login.php";
          return;
        }else{
            console.log("admin logged in")
        }
      }
})();
  