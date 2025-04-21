<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div id="cuopons" class="tab-content px-4 py-6">
  <h2 class="text-2xl font-semibold text-red-600 mb-6">Coupons</h2>

  <!-- Coupon Form -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col gap-2">
      <label for="coupon" class="font-medium text-gray-700">Coupon Name</label>
      <input id="coupon" type="text" placeholder="Enter coupon name"
        class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col gap-2">
      <label for="couponValue" class="font-medium text-gray-700">Coupon Value</label>
      <input id="couponValue" type="number" placeholder="Enter coupon value"
        class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="flex items-end justify-start">
      <button onclick="submitCoupon()" class="bg-red-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-red-700">
        Submit Coupon
      </button>
    </div>
  </div>

  <!-- Coupons Table -->
  <div class="bg-white shadow rounded-2xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
      <thead class="bg-red-800 text-red-100 text-xs uppercase tracking-wider sticky top-0 z-10">
        <tr>
          <th class="px-6 py-3 text-left">Sl No</th>
          <th class="px-6 py-3 text-left">Name</th>
          <th class="px-6 py-3 text-center">Value</th>
          <th class="px-6 py-3 text-center">Action</th>
        </tr>
      </thead>
      <tbody id="tableBody" class="divide-y divide-gray-100 bg-white">
        <!-- Filled by JS -->
      </tbody>
    </table>
  </div>
</div>

<script>
//   const BASE_URL = "https://api.new.stockoutindia.com/api"; // update if different
    const couponMap = {};

    const couponMap = {};

async function fetchCoupons() {
  const token = localStorage.getItem('authToken');
  const response = await fetch("https://api.stockoutindia.com/api/coupon/index", {
    headers: { 'Authorization': `Bearer ${token}` }
  });

  const result = await response.json();
  console.log("Coupon fetch result:", result); // 👈 Add this

  const tbody = document.getElementById("tableBody");
  tbody.innerHTML = "";

  if (result.success && result.data.length > 0) {
    result.data.forEach((item, index) => {
      couponMap[item.id] = item;

      const row = `
        <tr>
          <td class="px-6 py-4">${index + 1}</td>
          <td class="px-6 py-4">${item.name}</td>
          <td class="px-6 py-4 text-center">₹${item.value}</td>
          <td class="px-6 py-4 text-center space-x-2">
            <button onclick="viewCoupon(${item.id})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">View</button>
            <button onclick="updateCoupon(${item.id})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Update</button>
            <button onclick="deleteCoupon(${item.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
          </td>
        </tr>`;
      tbody.insertAdjacentHTML('beforeend', row);
    });
  } else {
    console.warn("No data found or success is false.");
    tbody.innerHTML = `<tr><td colspan="4" class="text-center px-6 py-4 text-gray-500">No Coupons Found</td></tr>`;
  }
}


    function viewCoupon(id) {
    const data = couponMap[id];
    if (!data) return;

    Swal.fire({
        title: `Coupon: ${data.name}`,
        html: `<strong>Value:</strong> ₹${data.value}<br><strong>Active:</strong> ${data.is_active === "1" ? "Yes" : "No"}`,
        icon: "info"
    });
    }


  function submitCoupon() {
    const name = document.getElementById("coupon").value.trim();
    const value = document.getElementById("couponValue").value.trim();
    const token = localStorage.getItem('authToken');

    if (!name || !value) {
      Swal.fire("Error", "Please enter both name and value.", "error");
      return;
    }

    fetch(`<?php echo BASE_URL; ?>/coupon/add`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${token}`
      },
      body: JSON.stringify({
        name: name,
        value: value,
        is_active: "1"
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire("Success", "Coupon added successfully", "success");
        fetchCoupons();
        document.getElementById("coupon").value = "";
        document.getElementById("couponValue").value = "";
      } else {
        Swal.fire("Error", data.message || "Something went wrong.", "error");
      }
    });
  }

  function updateCoupon(id) {
    Swal.fire("Coming Soon", "Update feature not implemented yet", "info");
  }

  function deleteCoupon(id) {
    Swal.fire("Coming Soon", "Delete feature not implemented yet", "info");
  }

  // Initial load
  fetchCoupons();
</script>
