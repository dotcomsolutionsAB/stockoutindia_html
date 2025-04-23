<div id="coupons" class="tab-content px-4 py-6">
  <h2 class="text-2xl font-semibold text-red-600 mb-6">Coupons</h2>

  <!-- Coupon Form -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow flex flex-col gap-2">
      <label for="coupon" class="font-medium text-gray-700">Coupon Name</label>
      <input id="coupon" type="text" placeholder="Enter coupon name"
        class="border border-gray-300 rounded p-2 focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="bg-white p-6 rounded-lg shadow flex flex-col gap-2">
      <label for="couponValue" class="font-medium text-gray-700">Coupon Value</label>
      <input id="couponValue" type="number" placeholder="Enter value"
        class="border border-gray-300 rounded p-2 focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="flex items-end">
      <button onclick="submitCoupon()"
        class="bg-red-600 text-white font-semibold px-6 py-3 rounded hover:bg-red-700">
        Submit Coupon
      </button>
    </div>
  </div>

  <!-- Coupons Table -->
  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="w-full text-sm text-left text-gray-700">
      <thead class="bg-red-700 text-white text-xs uppercase">
        <tr>
          <th class="px-6 py-3">Sl No</th>
          <th class="px-6 py-3">Coupon Name</th>
          <th class="px-6 py-3">Value (₹)</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody id="couponTableBody" class="divide-y divide-gray-200">
        <!-- Dynamic rows will be inserted here -->
      </tbody>
    </table>
  </div>
</div>

<script>
  const BASE_URL = "<?php echo BASE_URL; ?>"; // Make sure this is echoed in PHP properly
  const couponMap = {};

  // Load Coupons on Page Load
  document.addEventListener("DOMContentLoaded", fetchCoupons);

  function fetchCoupons() {
    const token = localStorage.getItem("authToken");
    if (!token) {
      Swal.fire("Error", "You are not logged in.", "error");
      return;
    }

    fetch(`${BASE_URL}/coupon/index`, {
      headers: {
        "Authorization": `Bearer ${token}`
      }
    })
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById("couponTableBody");
        tbody.innerHTML = "";

        if (data.success && Array.isArray(data.data)) {
          data.data.forEach((coupon, index) => {
            couponMap[coupon.id] = coupon;
            const row = `
                    <tr>
                      <td class="px-6 py-4">${index + 1}</td>
                      <td class="px-6 py-4">${coupon.name}</td>
                      <td class="px-6 py-4">₹${coupon.value}</td>
                      <td class="px-6 py-4">${coupon.is_active === "1" ? "✅ Active" : "❌ Inactive"}</td>
                      <td class="px-6 py-4 text-center space-x-2">
                        <button onclick="viewCoupon(${coupon.id})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">View</button>
                        <button onclick="editCoupon(${coupon.id})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Update</button>
                        <button onclick="deleteCoupon(${coupon.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                      </td>
                    </tr>
                  `;
            tbody.insertAdjacentHTML("beforeend", row);
          });
        } else {
          tbody.innerHTML = `<tr><td colspan="4" class="text-center px-6 py-4 text-gray-500">No Coupons Found</td></tr>`;
        }
      })
      .catch(error => {
        console.error("Error fetching coupons:", error);
        Swal.fire("Error", "Failed to fetch coupons.", "error");
      });
  }

  function deleteCoupon(id) {
    const token = localStorage.getItem("authToken");

    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the coupon.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`${BASE_URL}/coupon/${id}`, {
          method: "DELETE",
          headers: {
            "Authorization": `Bearer ${token}`
          }
        })
        .then(res => {
          if (res.ok) {
            Swal.fire("Deleted!", "Coupon has been deleted.", "success");
            fetchCoupons();
          } else {
            Swal.fire("Error", "Failed to delete coupon.", "error");
          }
        })
        .catch(error => {
          console.error("Delete error:", error);
          Swal.fire("Error", "Server error while deleting.", "error");
        });
      }
    });
  }

  function editCoupon(id) {
    const coupon = couponMap[id];
    if (!coupon) return;

    Swal.fire({
      title: `Update Coupon: ${coupon.name}`,
      html: `
        <input id="editName" class="swal2-input" placeholder="Coupon Name" value="${coupon.name}">
        <input id="editValue" type="number" class="swal2-input" placeholder="Coupon Value" value="${coupon.value}">
        <select id="editStatus" class="swal2-select" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
          <option value="1" ${coupon.is_active === "1" ? "selected" : ""}>Active</option>
          <option value="0" ${coupon.is_active === "0" ? "selected" : ""}>Inactive</option>
        </select>
      `,
      confirmButtonText: 'Update',
      showCancelButton: true,
      focusConfirm: false,
      preConfirm: () => {
        const name = document.getElementById('editName').value.trim();
        const value = document.getElementById('editValue').value.trim();
        const is_active = document.getElementById('editStatus').value;

        if (!name || !value) {
          Swal.showValidationMessage('Please fill out all fields');
          return false;
        }

        return { name, value, is_active };
      }
    }).then(result => {
      if (result.isConfirmed && result.value) {
        const token = localStorage.getItem("authToken");

        fetch(`${BASE_URL}/coupon/edit/${id}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
          },
          body: JSON.stringify({
            name: result.value.name,
            value: result.value.value,
            is_active: result.value.is_active
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire("Updated!", "Coupon updated successfully.", "success");
            fetchCoupons();
          } else {
            Swal.fire("Error", data.message || "Failed to update coupon.", "error");
          }
        })
        .catch(error => {
          console.error("Update error:", error);
          Swal.fire("Error", "Server error occurred while updating.", "error");
        });
      }
    });
  }

  function submitCoupon() {
    const name = document.getElementById("coupon").value.trim();
    const value = document.getElementById("couponValue").value.trim();
    const token = localStorage.getItem("authToken");

    if (!name || !value) {
      Swal.fire("Error", "Please fill in both fields.", "error");
      return;
    }

    fetch(`${BASE_URL}/coupon/add`, {
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
          Swal.fire("Success", "Coupon added!", "success");
          document.getElementById("coupon").value = "";
          document.getElementById("couponValue").value = "";
          fetchCoupons();
        } else {
          Swal.fire("Error", data.message || "Failed to add coupon", "error");
        }
      })
      .catch(error => {
        console.error("Submit error:", error);
        Swal.fire("Error", "Server error occurred.", "error");
      });
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
</script>
