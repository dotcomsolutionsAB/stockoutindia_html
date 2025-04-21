<?php
/* -------------------------------------------------------------
   Make sure BASE_URL is defined once in your bootstrap / config
   ------------------------------------------------------------- */
if (!defined('BASE_URL')) {
    define('BASE_URL', 'https://api.stockoutindia.com/api');   // adjust to match your server
}
?>
<!-- SweetAlert2 (pop‑ups) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ⬇⬇ COUPON SECTION ⬇⬇ -->
<div id="coupons" class="tab-content px-4 py-6">
  <h2 class="text-2xl font-semibold text-red-600 mb-6">Coupons</h2>

  <!-- ── Coupon Form ─────────────────────────────────────────── -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col gap-2">
      <label for="couponName" class="font-medium text-gray-700">Coupon Name</label>
      <input id="couponName" type="text" placeholder="Enter coupon name"
             class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col gap-2">
      <label for="couponValue" class="font-medium text-gray-700">Coupon Value (₹)</label>
      <input id="couponValue" type="number" placeholder="Value"
             class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="flex items-end">
      <button id="submitBtn"
              class="bg-red-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-red-700 w-full md:w-auto">
        Submit Coupon
      </button>
    </div>
  </div>

  <!-- ── Coupons Table ───────────────────────────────────────── -->
  <div class="bg-white shadow rounded-2xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
      <thead class="bg-red-800 text-red-100 text-xs uppercase tracking-wider sticky top-0 z-10">
        <tr>
          <th class="px-6 py-3 text-left">Sl&nbsp;No</th>
          <th class="px-6 py-3 text-left">Name</th>
          <th class="px-6 py-3 text-center">Value</th>
          <th class="px-6 py-3 text-center">Action</th>
        </tr>
      </thead>
      <tbody id="couponTableBody" class="divide-y divide-gray-100 bg-white">
        <!-- Rows are injected here -->
      </tbody>
    </table>
  </div>
</div>

<script>
/*  ──────────────────────────────────────────────────────────────
    CONFIG
    ────────────────────────────────────────────────────────────── */
const BASE_URL   = "<?= BASE_URL ?>";        // PHP → JS once
const couponMap  = {};                       // stores coupons by id

/*  ──────────────────────────────────────────────────────────────
    HELPERS
    ────────────────────────────────────────────────────────────── */
function formatINR(value) {
  // Simple ₹ formatter without Intl for max browser reach
  return `₹${parseFloat(value).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
}

function toast(title, icon = "success") {
  Swal.fire({toast: true, position: "top", timer: 3000, showConfirmButton: false, icon, title});
}

/*  ──────────────────────────────────────────────────────────────
    FETCH & RENDER
    ────────────────────────────────────────────────────────────── */
async function fetchCoupons() {
  const token = localStorage.getItem('authToken');
  const tbody = document.getElementById("couponTableBody");
  tbody.innerHTML = "";

  try {
    const res = await fetch(`${BASE_URL}/coupon/index`, {
      headers: { Authorization: `Bearer ${token}` }
    });

    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const { success, data } = await res.json();

    if (!success || !Array.isArray(data) || data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No coupons found</td></tr>`;
      return;
    }

    data.forEach((c, i) => {
      couponMap[c.id] = c;                                   // cache
      tbody.insertAdjacentHTML("beforeend", `
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4">${i + 1}</td>
          <td class="px-6 py-4">${c.name}</td>
          <td class="px-6 py-4 text-center">${formatINR(c.value)}</td>
          <td class="px-6 py-4 text-center space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                    onclick="viewCoupon(${c.id})">View</button>
            <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                    onclick="updateCoupon(${c.id})">Update</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                    onclick="deleteCoupon(${c.id})">Delete</button>
          </td>
        </tr>`);
    });
  } catch (err) {
    console.error(err);
    Swal.fire("Error", "Could not load coupons.", "error");
    tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Error loading data</td></tr>`;
  }
}

/*  ──────────────────────────────────────────────────────────────
    CRUD ACTIONS
    ────────────────────────────────────────────────────────────── */
async function addCoupon() {
  const name  = document.getElementById("couponName").value.trim();
  const value = document.getElementById("couponValue").value.trim();
  const token = localStorage.getItem('authToken');

  if (!name || !value) {
    Swal.fire("Required", "Please enter coupon name and value.", "warning");
    return;
  }

  try {
    const res   = await fetch(`${BASE_URL}/coupon/add`, {
      method : "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization : `Bearer ${token}`
      },
      body: JSON.stringify({ name, value, is_active: "1" })
    });
    const json  = await res.json();

    if (json.success) {
      toast("Coupon added");
      document.getElementById("couponName").value  = "";
      document.getElementById("couponValue").value = "";
      fetchCoupons();
    } else {
      Swal.fire("Error", json.message || "Failed to add coupon.", "error");
    }
  } catch (err) {
    console.error(err);
    Swal.fire("Error", "Server error. Please try again.", "error");
  }
}

function viewCoupon(id) {
  const c = couponMap[id];
  if (!c) return;
  Swal.fire({
    title: c.name,
    html : `<b>Value:</b> ${formatINR(c.value)}<br><b>Active:</b> ${c.is_active === "1" ? "Yes" : "No"}`,
    icon : "info"
  });
}

/* TODO: wire updateCoupon() & deleteCoupon() with your API */
function updateCoupon(id) { Swal.fire("Coming soon"); }
function deleteCoupon(id) { Swal.fire("Coming soon"); }

/*  ──────────────────────────────────────────────────────────────
    EVENT BINDINGS
    ────────────────────────────────────────────────────────────── */
document.getElementById("submitBtn").addEventListener("click", addCoupon);
document.addEventListener("DOMContentLoaded", fetchCoupons);
</script>
<!-- ⬆⬆ END COUPON SECTION ⬆⬆ -->
