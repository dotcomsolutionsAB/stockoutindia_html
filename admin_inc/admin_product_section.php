<div id="view-products" class="tab-content active">
    <h2 class="text-2xl font-semibold text-red-600 mb-6">View Products</h2>

    <!-- Search and Filters Section -->
    <div class="flex items-center space-x-4 mb-6">
        <!-- Search Bar -->
        <input type="text" id="search" class="border px-4 py-2 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Search Products">

        <!-- Status Select Box -->
        <select id="status" class="border px-4 py-2 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500">
            <option value="">Select Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

<!-- Industry Select Box -->
<div class="relative w-64">
    <select id="industry" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple>
        <!-- Options will be populated by API -->
    </select>
    <label for="industry" class="absolute left-4 top-0 text-gray-500 text-sm">Industry</label>
</div>

<!-- Sub-Industry Select Box -->
<div class="relative w-64">
    <select id="sub-industry" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple>
        <!-- Options will be populated by API -->
    </select>
    <label for="sub-industry" class="absolute left-4 top-0 text-gray-500 text-sm">Sub-Industry</label>
</div>



        <!-- Apply Filters Button -->
        <button id="apply-filters" class="bg-red-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Apply Filters</button>
    </div>

    <!-- Products Table -->
    <table class="min-w-full table-auto border-collapse border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-red-600 text-white">
            <tr>
                <th class="border-b-2 px-6 py-3 text-left">Image</th>
                <th class="border-b-2 px-6 py-3 text-left">Product Name</th>
                <th class="border-b-2 px-6 py-3 text-left">Offer Quantity</th>
                <th class="border-b-2 px-6 py-3 text-left">Minimum Quantity</th>
                <th class="border-b-2 px-6 py-3 text-left">Original Price</th>
                <th class="border-b-2 px-6 py-3 text-left">Selling Price</th>
                <th class="border-b-2 px-6 py-3 text-left">Status</th>
                <th class="border-b-2 px-6 py-3 text-left">Unit</th>
                <th class="border-b-2 px-6 py-3 text-left">Validity</th>
                <th class="border-b-2 px-6 py-3 text-left">Industry</th>
                <th class="border-b-2 px-6 py-3 text-left">Sub-Industry</th>
                <th class="border-b-2 px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody id="product-table-body" class="bg-gray-50">
            <!-- Products will be populated here by JS -->
        </tbody>
    </table>

    <!-- Count and Pagination Section -->
    <div class="flex justify-between items-center mt-6">
        <!-- Total Count -->
        <span id="total-count" class="text-lg font-semibold text-gray-800">Total Products: 0</span>

        <!-- Pagination Controls -->
        <div id="pagination-controls" class="space-x-2">
            <!-- Pagination buttons will be added dynamically -->
        </div>
    </div>
</div>

<script>
    // Fetch Auth Token from localStorage
    const authToken = localStorage.getItem('authToken');

    // Function to fetch industry and sub-industry options
    async function fetchIndustriesAndSubIndustries() {
        try {
            const industryResponse = await fetch('<?php echo BASE_URL; ?>/industry', { method: 'GET' });
            const industryData = await industryResponse.json();

            const subIndustryResponse = await fetch('<?php echo BASE_URL; ?>/sub_industry', { method: 'GET' });
            const subIndustryData = await subIndustryResponse.json();

            // Populate Industry Select Box
            const industrySelect = document.getElementById('industry');
            industryData.data.forEach(industry => {
                const option = document.createElement('option');
                option.value = industry.id;
                option.textContent = industry.name;
                industrySelect.appendChild(option);
            });

            // Populate Sub-Industry Select Box
            const subIndustrySelect = document.getElementById('sub-industry');
            subIndustryData.data.forEach(subIndustry => {
                const option = document.createElement('option');
                option.value = subIndustry.id;
                option.textContent = subIndustry.name;
                subIndustrySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching industries or sub-industries:', error);
        }
    }

    // Function to fetch products with applied filters
    async function fetchProducts(filters) {
        try {
            const response = await fetch('<?php echo BASE_URL; ?>/admin/products', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(filters),
            });

            const data = await response.json();
            if (data.success) {
                // Display products in table
                const products = data.data;
                const totalCount = data.total_count;

                // Update product count
                document.getElementById('total-count').textContent = `Total Products: ${totalCount}`;

                // Clear the table body
                const tableBody = document.getElementById('product-table-body');
                tableBody.innerHTML = '';

                // Populate table with products
                products.forEach(product => {
                    const row = document.createElement('tr');
                    row.classList.add('hover:bg-gray-100');

                    row.innerHTML = `
                        <td class="border-b px-6 py-4">
                            <img src="uploads/${product.image || 'placeholder.png'}" alt="Product Image" class="w-16 h-16 object-cover rounded-full">
                        </td>
                        <td class="border-b px-6 py-4">${product.product_name}</td>
                        <td class="border-b px-6 py-4">${product.offer_quantity}</td>
                        <td class="border-b px-6 py-4">${product.minimum_quantity}</td>
                        <td class="border-b px-6 py-4">$${product.original_price}</td>
                        <td class="border-b px-6 py-4">$${product.selling_price}</td>
                        <td class="border-b px-6 py-4">${product.status}</td>
                        <td class="border-b px-6 py-4">${product.unit}</td>
                        <td class="border-b px-6 py-4">${product.validity || 'N/A'}</td>
                        <td class="border-b px-6 py-4">${product.industry}</td>
                        <td class="border-b px-6 py-4">${product.sub_industry}</td>
                        <td class="border-b px-6 py-4">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Handle pagination
                handlePagination(totalCount);
            }
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    }

    // Function to handle pagination
    function handlePagination(totalCount) {
        const itemsPerPage = 10;
        const totalPages = Math.ceil(totalCount / itemsPerPage);
        const paginationControls = document.getElementById('pagination-controls');
        paginationControls.innerHTML = '';

        // Create pagination buttons
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.className = 'bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600';
            button.addEventListener('click', () => {
                const filters = getFilters();
                filters.offset = (i - 1) * itemsPerPage;
                fetchProducts(filters);
            });
            paginationControls.appendChild(button);
        }
    }

    // Function to get filters from the UI
    function getFilters() {
        const productName = document.getElementById('search').value;
        const status = document.getElementById('status').value;
        const industry = Array.from(document.getElementById('industry').selectedOptions).map(option => option.value).join(',');
        const subIndustry = Array.from(document.getElementById('sub-industry').selectedOptions).map(option => option.value).join(',');

        return {
            product_name: productName,
            status: status,
            industry: industry,
            sub_industry: subIndustry,
            limit: 10,
            offset: 0,
        };
    }

    // Event Listener for Apply Filters Button
    document.getElementById('apply-filters').addEventListener('click', () => {
        const filters = getFilters();
        fetchProducts(filters);
    });

    // Initialize
    fetchIndustriesAndSubIndustries();
    fetchProducts(getFilters());
</script>
