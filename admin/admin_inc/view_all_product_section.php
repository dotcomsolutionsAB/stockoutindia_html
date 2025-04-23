<div id="view-products" class="tab-content">
  <div class="max-w-7xl mx-auto space-y-8">
    <!-- ╭─ FILTER PANEL ───────────────────────────────────────────────────╮ -->
    <section id="filters" class="bg-white shadow rounded-2xl p-3 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
      <div class="flex flex-col gap-1">
        <!-- Status -->
        <div class="flex flex-col gap-1">
          <!-- <label for="statusFilter" class="font-medium text-gray-700">Status</label> -->
          <select id="statusFilter" class="bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-red-500 focus:border-red-500">
            <option value="">Status</option>
            <option value="active">Active</option>
            <option value="in-active">Inactive</option>
            <option value="sold">Sold</option>
          </select>
        </div>

        <!-- Min price -->
        <div class="flex flex-col gap-1">
          <!-- <label for="minPrice" class="font-medium text-gray-700">Min Price (₹)</label> -->
          <input id="minPrice" type="number" min="0" placeholder="min-Price (₹)" class="bg-gray-50 border border-gray-300 rounded-lg p-2
                          focus:ring-red-500 focus:border-red-500">
        </div>

        <!-- Max price -->
        <div class="flex flex-col gap-1">
          <!-- <label for="maxPrice" class="font-medium text-gray-700">Max Price (₹)</label> -->
          <input id="maxPrice" type="number" min="0" placeholder="max-Price (₹) ∞" class="bg-gray-50 border border-gray-300 rounded-lg p-2
                          focus:ring-red-500 focus:border-red-500">
        </div>
      </div>

      <!-- Industry list -->
      <div class="flex flex-col gap-1">
        <!-- <span class="font-medium text-gray-700">Industry</span> -->
        <input id="industrySearch" type="text" placeholder="Search Industry" class="mb-1 w-full bg-gray-50 border border-gray-300 rounded-md p-2
                      text-sm focus:ring-red-500 focus:border-red-500">
        <div id="industryList" class="bg-gray-50 border border-gray-300 rounded-lg p-2
                      h-20 overflow-y-auto space-y-1"></div>
      </div>
      <!-- Sub‑industry list -->
      <div class="flex flex-col gap-1">
        <!-- <span class="font-medium text-gray-700">Sub‑Industry</span> -->
        <input id="subIndustrySearch" type="text" placeholder="Search Sub Industry" class="mb-1 w-full bg-gray-50 border border-gray-300 rounded-md p-2
                      text-sm focus:ring-red-500 focus:border-red-500">
        <div id="subIndustryList" class="bg-gray-50 border border-gray-300 rounded-lg p-2
                      h-20 overflow-y-auto space-y-1"></div>
      </div>

      <div class="flex flex-col gap-1">
        <!-- Search (product name) -->
        <div class="flex flex-col gap-1">
          <!-- <label for="searchInput" class="font-medium text-gray-700">Search</label> -->
          <div class="relative">
            <input id="searchInput" type="text" placeholder="Product name…" class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300
                              focus:ring-2 focus:ring-red-500 focus:border-red-500
                              placeholder:text-gray-400">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35m2.31-5.3a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
        </div>
        <!-- Apply button -->
        <div class="col-span-full flex justify-end pt-2">
          <button id="applyFilters" class="inline-flex items-center gap-1 px-5 py-2.5 bg-red-600
                              hover:bg-red-500 text-white font-medium rounded-lg shadow-lg
                              focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
            Apply Filters
          </button>
        </div>
      </div>
    </section>
    <!-- ╰────────────────────────────────────────────────────────────────────╯ -->

    <!-- ╭─ TABLE ────────────────────────────────────────────────────────────╮ -->
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
    <!-- ╰────────────────────────────────────────────────────────────────────╯ -->

    <!-- Footer -->
    <footer class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-gray-700">
      <div id="resultCount">0 results</div>
      <nav id="pagination" class="flex items-center gap-2"></nav>
    </footer>
  </div>

  <!-- Row template -->
  <template id="rowTemplate">
    <tr class="hover:bg-gray-50">
      <!-- replace the first two <td> blocks with this one -->
      <td class="px-6 py-4">
        <div class="flex items-center gap-3">
          <img data-field="image" class="h-12 w-12 rounded object-cover ring-1 ring-gray-200 shrink-0" alt="Product">
          <span data-field="product_name" class="font-medium text-gray-900 break-words w-48"></span>
        </div>
      </td>
      <!-- keep the rest of the <td> cells exactly as before -->

      <!-- <td class="px-6 py-4 whitespace-nowrap">
              <img data-field="image" class="h-12 w-12 rounded object-cover ring-1 ring-gray-200" alt="Product">
          </td>
          <td class="px-6 py-4 font-medium text-gray-900" data-field="product_name"></td> -->
      <td class="px-6 py-4 text-center" data-field="offer_quantity"></td>
      <td class="px-6 py-4 text-center" data-field="minimum_quantity"></td>
      <td class="px-6 py-4 text-right" data-field="original_price"></td>
      <td class="px-6 py-4 text-right" data-field="selling_price"></td>
      <td class="px-6 py-4 text-center" data-field="status"></td>
      <td class="px-6 py-4 text-center" data-field="unit"></td>
      <td class="px-6 py-4 text-center" data-field="validity"></td>
      <td class="px-6 py-4" data-field="industry"></td>
      <td class="px-6 py-4" data-field="sub_industry"></td>
      <!-- Row template: swap the old single button cell with this -->
      <td class="px-6 py-4 text-center space-x-1">
        <!-- View -->
        <button class="viewBtn inline-flex items-center justify-center w-8 h-8 rounded-full
                      text-white bg-indigo-600 hover:bg-indigo-500
                      focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow" title="View">
          <i data-lucide="eye"></i>
        </button>

        <!-- Update -->
        <button class="updateBtn inline-flex items-center justify-center w-8 h-8 rounded-full
                      text-white bg-blue-600 hover:bg-blue-500
                      focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow" title="Update">
          <i data-lucide="pencil"></i>
        </button>

        <!-- Delete -->
        <button class="deleteBtn inline-flex items-center justify-center w-8 h-8 rounded-full
                      text-white bg-red-600 hover:bg-red-500
                      focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow" title="Delete">
          <i data-lucide="trash-2"></i>
        </button>
      </td>
    </tr>
  </template>

</div>

<!-- ╭─ JAVASCRIPT ─────────────────────────────────────────────────────────╮ -->
<script>
  lucide.createIcons();

  /* ------------------------------------------------------------------
    BASE URL from PHP
  ------------------------------------------------------------------ */
  const API_URL = `<?php echo BASE_URL; ?>/admin/products`;
  const INDUSTRY_URL = `<?php echo BASE_URL; ?>/industry`;
  const SUB_INDUSTRY_URL = `<?php echo BASE_URL; ?>/sub_industry`;

  /* ------------------------------------------------------------------
    STATE & CONSTANTS
  ------------------------------------------------------------------ */
  const limitt = 10;
  let currentPage_allPro = 1;
  let totalResults_allPro = 0;

  /* ------------------------------------------------------------------
    HELPER – checkbox element
  ------------------------------------------------------------------ */
  const makeCheckbox_allPro = (value, label, cls) => {
    const lbl = document.createElement('label');
    lbl.className = 'inline-flex items-center gap-2 w-full text-gray-700';
    lbl.innerHTML =
      `<input type="checkbox" value="${value}" class="${cls} accent-red-600 rounded">
    <span>${label}</span>`;
    return lbl;
  };

  /* ------------------------------------------------------------------
    BUILD INDUSTRY & SUB‑INDUSTRY LISTS
  ------------------------------------------------------------------ */
  async function initCheckList(url, wrapEl, cls, labelFormatter) {
    try {
      const token = localStorage.getItem('authToken');
      const res = await fetch(url, { headers: { Authorization: `Bearer ${token}` } });
      const json = await res.json();
      if (!json.success) throw new Error('Failed list load');
      json.data.forEach(item => wrapEl.appendChild(makeCheckbox_allPro(item.id, labelFormatter(item), cls)));
    } catch (err) { console.error(err); }
  }

  /* Simple live‑search for the checkbox lists */
  function attachSearch(inputId, listId) {
    const search = document.getElementById(inputId);
    const list = document.getElementById(listId);
    search.addEventListener('input', () => {
      const term = search.value.trim().toLowerCase();
      list.querySelectorAll('label').forEach(lbl =>
        lbl.classList.toggle('hidden', !lbl.textContent.toLowerCase().includes(term))
      );
    });
  }

  /* ------------------------------------------------------------------
    FETCH PRODUCTS
  ------------------------------------------------------------------ */
  async function fetchProducts() {
    const token = localStorage.getItem('authToken');
    const search = document.getElementById('searchInput').value.trim();
    const status = document.getElementById('statusFilter').value;
    const minP = document.getElementById('minPrice').value;
    const maxP = document.getElementById('maxPrice').value;
    const indIds = [...document.querySelectorAll('.industryChk:checked')].map(c => c.value).join(',');
    const subIds = [...document.querySelectorAll('.subChk:checked')].map(c => c.value).join(',');

    const payload = {
      product_name: search || undefined,
      industry: indIds || undefined,
      sub_industry: subIds || undefined,
      status: status || undefined,
      min_amount: minP ? Number(minP) : undefined,
      max_amount: maxP ? Number(maxP) : undefined,
      limitt,
      offset: (currentPage_allPro - 1) * limitt
    };
    Object.keys(payload).forEach(k => payload[k] === undefined && delete payload[k]);

    try {
      const res = await fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}` },
        body: JSON.stringify(payload)
      });
      const json = await res.json();
      if (!json.success) throw new Error(json.message || 'API error');
      totalResults_allPro = json.total_count || json.data.length;
      renderTable(json.data);
    } catch (err) {
      console.error(err);
      totalResults_allPro = 0;
      renderTable([]);
    }
    renderPagination();
    document.getElementById('resultCount').textContent =
      `${totalResults_allPro} result${totalResults_allPro !== 1 ? 's' : ''}`;
  }

  /* ------------------------------------------------------------------
    RENDER TABLE
  ------------------------------------------------------------------ */
  // helper once, outside renderTable():
  const rupee_allPro = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR',
    maximumFractionDigits: 0       // change if you need paise
  });

  function renderTable(rows) {
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';
    const tmpl = document.getElementById('rowTemplate');

    rows.forEach(row => {
      const tr = tmpl.content.cloneNode(true);
      const imgEl = tr.querySelector('[data-field="image"]');
      const nameEl = tr.querySelector('[data-field="product_name"]');

      const imgSrc = Array.isArray(row.image) && row.image.length
        ? row.image[0]
        : '../uploads/placeholder.png';

      imgEl.src = imgSrc;
      nameEl.textContent = row.product_name || '';

      tr.querySelector('[data-field="offer_quantity"]').textContent = row.offer_quantity ?? '-';
      tr.querySelector('[data-field="minimum_quantity"]').textContent = row.minimum_quantity ?? '-';
      tr.querySelector('[data-field="original_price"]').textContent = row.original_price != null ? rupee_allPro.format(row.original_price) : '–';
      tr.querySelector('[data-field="selling_price"]').textContent = row.selling_price != null ? rupee_allPro.format(row.selling_price) : '–';

      // ✅ STATUS SELECT BOX LOGIC
      const statusTd = tr.querySelector('[data-field="status"]');
      const statusSelect = document.createElement('select');
      statusSelect.className = 'border rounded px-2 py-1 text-sm';

      const statusOptions = ['active', 'in-active', 'sold'];

      statusOptions.forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        if (row.status === status) {
          option.selected = true;
        }
        statusSelect.appendChild(option);
      });

      statusSelect.addEventListener('change', () => {
        const selectedStatus = statusSelect.value;

        const token = localStorage.getItem('authToken');
        const payload = {
          product_id: row.id,
          product_status: selectedStatus // 'active', 'in-active', or 'sold'
        };
        
        fetch('<?php echo BASE_URL; ?>/admin/product_toggle_status', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(payload)
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert(`Status updated to "${selectedStatus}"`);
            } else {
              alert('Failed to update status.');
              statusSelect.value = row.status; // rollback
            }
          })
          .catch(error => {
            console.error('Error updating status:', error);
            alert('Something went wrong.');
            statusSelect.value = row.status; // rollback
          });
      });

      statusTd.innerHTML = '';
      statusTd.appendChild(statusSelect);

      tr.querySelector('[data-field="unit"]').textContent = row.unit || '-';
      tr.querySelector('[data-field="validity"]').textContent = row.validity || '-';
      tr.querySelector('[data-field="industry"]').textContent = row.industry?.name ?? '-';
      tr.querySelector('[data-field="sub_industry"]').textContent = row.sub_industry?.name ?? '-';

      tr.querySelector('.viewBtn').addEventListener('click', () => {
        alert(`View product #${row.id}`);
      });

      tr.querySelector('.updateBtn').addEventListener('click', () => {
        alert(`Update product #${row.id}`);
      });

      tr.querySelector('.deleteBtn').addEventListener('click', () => {
        if (confirm(`Delete product #${row.id}?`)) {
          alert('Perform delete here…');
        }
      });

      tbody.appendChild(tr);
    });

    lucide.createIcons();
  }


  /* ------------------------------------------------------------------
    PAGINATION
  ------------------------------------------------------------------ */
  function renderPagination() {
    const nav = document.getElementById('pagination');
    nav.innerHTML = '';
    const totalPages = Math.max(1, Math.ceil(totalResults_allPro / limitt));

    const btn = (label, page, disabled = false) => {
      const b = document.createElement('button');
      b.textContent = label;
      b.dataset.page = page;
      b.disabled = disabled;
      b.className =
        `px-3 py-1.5 rounded-md border transition ${page === currentPage_allPro
          ? 'bg-red-600 text-white border-red-600'
          : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
        } ${disabled ? 'opacity-50 cursor-not-allowed' : ''}`;
      return b;
    };

    nav.appendChild(btn('Prev', Math.max(1, currentPage_allPro - 1), currentPage_allPro === 1));
    for (let p = 1; p <= totalPages; p++) nav.appendChild(btn(p, p));
    nav.appendChild(btn('Next', Math.min(totalPages, currentPage_allPro + 1), currentPage_allPro === totalPages));
  }

  /* ------------------------------------------------------------------
    EVENT HANDLERS
  ------------------------------------------------------------------ */
  document.getElementById('applyFilters').addEventListener('click', () => {
    currentPage_allPro = 1;
    fetchProducts();
  });
  document.getElementById('pagination').addEventListener('click', e => {
    if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
      currentPage_allPro = Number(e.target.dataset.page);
      fetchProducts();
    }
  });

  /* ------------------------------------------------------------------
    INITIALISE
  ------------------------------------------------------------------ */
  (async () => {
    await initCheckList(INDUSTRY_URL, document.getElementById('industryList'),
      'industryChk', i => i.name);
    await initCheckList(SUB_INDUSTRY_URL, document.getElementById('subIndustryList'),
      'subChk', s => s.name);

    attachSearch('industrySearch', 'industryList');
    attachSearch('subIndustrySearch', 'subIndustryList');

    fetchProducts();   // first load
  })();
</script>