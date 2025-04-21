<div id="cuopons" class="tab-content">
    <h2 class="text-2xl font-semibold text-red-600 mb-6">Cuopons</h2>
    <div class="flex">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="card bg-white p-4 rounded-lg shadow-md">
                <!-- Order Card -->
                <div class="flex flex-col gap-1">
                    <label for="coupon" class="font-medium text-gray-700">Coupon Name</label>
                    <input id="coupon" type="text" placeholder="coupon name" class="bg-gray-50 border border-gray-300 rounded-lg p-2
                                focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="couponValue" class="font-medium text-gray-700">Coupon Value</label>
                    <input id="couponValue" type="text" placeholder="coupon Value" class="bg-gray-50 border border-gray-300 rounded-lg p-2
                                focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
        </div>
        <div class="flex">
            <section class="bg-white shadow rounded-2xl overflow-x-auto mg-10p">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider bg-red-800 text-red-200 sticky top-0 z-10">
                    <tr>
                        <!-- <th class="px-6 py-3 text-left">Image</th> -->
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-center">Offer Qty</th>
                        <th class="px-6 py-3 text-center">Min Qty</th>
                        <th class="px-6 py-3 text-right">Original</th>
                        <th class="px-6 py-3 text-right">Selling</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Unit</th>
                        <th class="px-6 py-3 text-center">Validity</th>
                        <th class="px-6 py-3 text-left">Industry</th>
                        <th class="px-6 py-3 text-left">Sub‑Industry</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-100 bg-white"></tbody>
                </table>
            </section>
        </div>
    </div>
    
</div>