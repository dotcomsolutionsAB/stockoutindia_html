
  const token = localStorage.getItem('authToken');
  const role = localStorage.getItem('role');
  const pathname = window.location.pathname;

  // Public pages (no login required)
  const publicPages = [
    "/",
    "/index.php",
    "/pages/all-products.php",
    "/pages/all-industry.php"
  ];

  // Public pages with dynamic params
  const publicPatterns = [
    "/pages/product_detail.php",
    "/pages/filter-products.php"
  ];

  // Customer (user role) pages
  const customerPages = [
    "/pages/account.php",
    "/pages/profile.php",
    "/pages/setting.php"
  ];

  // Admin-only pages
  const adminPages = [
    "/admin/configurations.php",
    "/admin/admin_index.php",
    "/admin/tables.php"
  ];

  // Check if path starts with any pattern (for dynamic pages)
  function matchesPattern(path, patterns) {
    return patterns.some(pattern => path.startsWith(pattern));
  }

  function redirectToLogin(msg = "Unauthorized access.") {
    alert(msg);
    window.location.href = "/login.php";
  }

  // ROUTING LOGIC

  if (
    publicPages.includes(pathname) ||
    matchesPattern(pathname, publicPatterns)
  ) {
    // Allow public
  } else if (adminPages.includes(pathname)) {
    if (!token || role !== 'admin') {
      redirectToLogin("Access Denied !");
    }
  } else if (customerPages.includes(pathname)) {
    if (!token || role !== 'user') {
      redirectToLogin("Access Denied");
    }
  } else {
    // Unknown or protected page
    if (!token) {
      redirectToLogin("Please login to continue.");
    }
  }

