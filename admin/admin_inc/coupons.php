<div id="cuopons" class="tab-content px-4 py-6">
  <h2 class="text-2xl font-semibold text-red-600 mb-6">Coupons</h2>

  <!-- Coupon Form -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
      <div class="flex flex-col gap-2">
        <label for="coupon" class="font-medium text-gray-700">Coupon Name</label>
        <input id="coupon" type="text" placeholder="Enter coupon name"
          class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
      </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
      <div class="flex flex-col gap-2">
        <label for="couponValue" class="font-medium text-gray-700">Coupon Value</label>
        <input id="couponValue" type="text" placeholder="Enter coupon value"
          class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
      </div>
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
        <!-- Dynamically filled rows -->
      </tbody>
    </table>
  </div>
</div>
