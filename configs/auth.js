
  const token = localStorage.getItem('authToken');
  const role = localStorage.getItem('role');
  const pathname = window.location.pathname;

  // Public pages (no login required)
  const publicPages = [
    "/",
    "/index",
    "/pages/all-products",
    "/pages/all-industries",
    "/pages/faq",
    "/pages/privacy-policy",
    "/pages/refund-policy",
    "/pages/terms-condition"
  ];

  // Public pages with dynamic params
  const publicPatterns = [
    "/pages/product_detail",
    "/pages/filter-products"
  ];

  // Customer (user role) pages
  const customerPages = [
    "/pages/account",
    "/pages/profile",
    "/pages/setting"
  ];

  // Admin-only pages
  const adminPages = [
    "/admin/configurations",
    "/admin/admin_index",
    "../admin/tables"
  ];

  // Check if path starts with any pattern (for dynamic pages)
  function matchesPattern(path, patterns) {
    return patterns.some(pattern => path.startsWith(pattern));
  }

  function redirectToLogin(msg = "Unauthorized access.") {
    alert(msg);
    window.location.href = "/login";
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

