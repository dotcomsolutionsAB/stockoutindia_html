<div id="view-products" class="tab-content">
  <div class="max-w-7xl mx-auto space-y-8">
    <!-- ╭─ FILTER PANEL ───────────────────────────────────────────────────╮ -->
    <section id="filters" class="bg-white shadow rounded-2xl p-3 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
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

      <!-- User list (multi-select) -->
      <div class="flex flex-col gap-1">
        <input id="userSearch" type="text" placeholder="Search User"
              class="mb-1 w-full bg-gray-50 border border-gray-300 rounded-md p-2 text-sm focus:ring-red-500 focus:border-red-500">
        <div id="userList" class="bg-gray-50 border border-gray-300 rounded-lg p-2 h-20 overflow-y-auto space-y-1"></div>
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
<style>
  /* 𝗘𝗠𝗣𝗧𝗬 𝗦𝗧𝗔𝗧𝗘 ---------------------------------------------- */
  .empty-state {
    text-align:center;
    padding:3rem 1rem;
    color:#9ca3af;                /* tailwind: text-gray-400 */
  }
  .empty-state svg {
    width:48px; height:48px;
    margin:0 auto 0.75rem;
    stroke:#9ca3af;               /* same muted gray */
  }

</style>
<script>
  /* ───────────────────────────── GLOBALS ──────────────────────────── */
  lucide.createIcons();                                   // icons once

  const BASE     = `<?php echo BASE_URL; ?>`;
  const API_URL  = `${BASE}/admin/products`;
  const IDS_URL  = `${BASE}/industry`;
  const SUB_URL  = `${BASE}/sub_industry`;
  const USERS_URL= `${BASE}/admin/users_with_products`;

  const pageSize = 10;                 // ← limit per page
  let current    = 1;                  // page #
  let totalRows  = 0;

  /* ────────────────────────── DOM HELPERS ─────────────────────────── */
  const $ = sel => document.querySelector(sel);

  const makeCheckbox = (val, label, cls) => {
    const wrap   = document.createElement('label');
    wrap.className = 'inline-flex items-center gap-2 w-full text-gray-700';
    wrap.innerHTML =
      `<input type="checkbox" value="${val}" class="${cls} accent-red-600 rounded">
       <span>${label}</span>`;
    return wrap;
  };

  /* ───────────── Generic checklist builder (GET or POST) ──────────── */
  async function buildCheckList({url, body=null, wrapEl, cls, valueSel, labelSel}) {
    try {
      const token = localStorage.getItem('authToken');
      const res   = await fetch(url, {
        method : body ? 'POST' : 'GET',
        headers: { 'Content-Type':'application/json',
                   'Authorization': `Bearer ${token}` },
        body   : body ? JSON.stringify(body) : undefined
      });
      const json  = await res.json();
      if (!json.success) throw new Error(json.message || 'List error');

      json.data
          .filter(item => valueSel(item) !== null && valueSel(item) !== undefined)
          .forEach(item => wrapEl.appendChild(
              makeCheckbox(valueSel(item), labelSel(item), cls)
          ));
    } catch (err) { console.error(err); }
  }

  /* quick live-search inside a checklist */
  const attachSearch = (inputId, listId) => {
    const search = $(inputId), list = $(listId);
    search.addEventListener('input', () => {
      const q = search.value.trim().toLowerCase();
      list.querySelectorAll('label').forEach(l =>
        l.classList.toggle('hidden',
          !l.textContent.toLowerCase().includes(q)));
    });
  };

  /* ───────────────────────── FETCH PRODUCTS ───────────────────────── */
  async function fetchProducts() {
    const token   = localStorage.getItem('authToken');
    const q       = $('#searchInput').value.trim();
    const status  = $('#statusFilter').value;
    const minP    = $('#minPrice').value;
    const maxP    = $('#maxPrice').value;

    const csv = (cls) => [...document.querySelectorAll(`.${cls}:checked`)]
                          .map(c => c.value)
                          .filter(v => v && v !== 'null' && v !== 'undefined')
                          .join(',');

    const payload = {
      user          : csv('userChk')       || undefined,
      product_name  : q                    || undefined,
      industry      : csv('industryChk')   || undefined,
      sub_industry  : csv('subChk')        || undefined,
      status        : status               || undefined,
      min_amount    : minP ? +minP : undefined,
      max_amount    : maxP ? +maxP : undefined,
      limit         : pageSize,
      offset        : (current-1)*pageSize
    };
    Object.keys(payload).forEach(k => payload[k] === undefined && delete payload[k]);

    try {
      const res  = await fetch(API_URL, {
        method : 'POST',
        headers: { 'Content-Type':'application/json',
                   'Authorization': `Bearer ${token}` },
        body   : JSON.stringify(payload)
      });
      const json = await res.json();
      if (!json.success) throw new Error(json.message || 'API error');
      totalRows = json.total_count || json.data.length;
      renderTable(json.data);
    } catch (err) {
      console.error(err); totalRows = 0; renderTable([]);
    }
    renderPager();
    $('#resultCount').textContent = `${totalRows} result${totalRows!==1?'s':''}`;
  }

  /* ──────────────────────── RENDER TABLE ──────────────────────────── */
  const rupee = new Intl.NumberFormat('en-IN',
    {style:'currency',currency:'INR',maximumFractionDigits:0});

  function renderTable(rows) {
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';
    const tmpl = document.getElementById('rowTemplate');

    /* ───────── SHOW EMPTY-STATE IF NO ROWS ───────── */
    if (!rows.length) {
      const tr  = document.createElement('tr');
      const td  = document.createElement('td');
      td.colSpan = 11;                                  // ← span all table columns
      td.innerHTML = `
        <div class="empty-state">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 3h2l.4 2M7 13h14l-1.5 8H6.5L5 6h16" />
            <circle cx="9"  cy="21" r="1" />
            <circle cx="19" cy="21" r="1" />
          </svg>
          <p class="text-lg font-medium">No Products Found</p>
          <p class="text-sm">Try adjusting your filters</p>
        </div>`;
      tr.appendChild(td);
      tbody.appendChild(tr);
      lucide.createIcons();       // keep icons fresh (for other rows later)
      return;                     // nothing else to render
    }

    /* ───────── RENDER NORMAL ROWS WHEN PRESENT ───────── */
    rows.forEach(r => {
      const tr = tmpl.content.cloneNode(true);

      tr.querySelector('[data-field="image"]').src =
        Array.isArray(r.image) && r.image.length ? r.image[0]
                                                : '../uploads/placeholder.png';
      tr.querySelector('[data-field="product_name"]').textContent = r.product_name||'';
      tr.querySelector('[data-field="offer_quantity"]').textContent   = r.offer_quantity   ?? '-';
      tr.querySelector('[data-field="minimum_quantity"]').textContent = r.minimum_quantity ?? '-';

      tr.querySelector('[data-field="original_price"]').textContent =
        r.original_price!=null ? rupee.format(r.original_price) : '–';
      tr.querySelector('[data-field="selling_price"]').textContent  =
        r.selling_price !=null ? rupee.format(r.selling_price)  : '–';

      /* status dropdown, unit, validity, etc. (unchanged) */
      const sTd = tr.querySelector('[data-field="status"]');
      const sel = document.createElement('select');
      sel.className = 'border rounded px-2 py-1 text-sm';
      ['active','in-active','sold'].forEach(st=>{
        const o=document.createElement('option');
        o.value=st; o.textContent=st[0].toUpperCase()+st.slice(1);
        if(r.status===st) o.selected=true; sel.appendChild(o);
      });
      sel.onchange = () => updateStatus(r.id, sel, r.status);
      sTd.innerHTML=''; sTd.appendChild(sel);

      tr.querySelector('[data-field="unit"]').textContent        = r.unit        ?? '-';
      tr.querySelector('[data-field="validity"]').textContent    = r.validity    ?? '-';
      tr.querySelector('[data-field="industry"]').textContent    = r.industry?.name     ?? '-';
      tr.querySelector('[data-field="sub_industry"]').textContent= r.sub_industry?.name ?? '-';

      // tr.querySelector('.viewBtn')  .onclick = () => alert(`View #${r.id}`);
      // tr.querySelector('.updateBtn').onclick = () => alert(`Update #${r.id}`);
      // tr.querySelector('.deleteBtn').onclick = () =>
      //   confirm(`Delete #${r.id}?`) && alert('Perform delete…');

      // View product details in SweetAlert
      tr.querySelector('.viewBtn').onclick = () => {
        Swal.fire({
          title: `Product #${r.id}`,
          html: `
            <strong>Name:</strong> ${r.product_name}<br>
            <strong>Selling Price:</strong> ₹${r.selling_price}<br>
            <strong>Offer Quantity:</strong> ${r.offer_quantity}<br>
            <strong>Status:</strong> ${r.status}<br>
            <strong>Dimensions:</strong> ${r.dimensions || '-'}<br>
          `,
          icon: 'info'
        });
      };

      // Update product via SweetAlert form
      tr.querySelector('.updateBtn').onclick = () => {
        Swal.fire({
          title: `Update Product #${r.id}`,
          html: `
            <input id="swal_name" class="swal2-input" placeholder="Product Name" value="${r.product_name}">
            <input id="swal_price" class="swal2-input" type="number" placeholder="Selling Price" value="${r.selling_price}">
            <input id="swal_offer" class="swal2-input" type="number" placeholder="Offer Quantity" value="${r.offer_quantity}">
            <input id="swal_dim" class="swal2-input" placeholder="Dimensions" value="${r.dimensions || ''}">
            <select id="swal_status" class="swal2-input">
              <option value="active" ${r.status==='active'?'selected':''}>Active</option>
              <option value="in-active" ${r.status==='in-active'?'selected':''}>In-active</option>
              <option value="sold" ${r.status==='sold'?'selected':''}>Sold</option>
            </select>
          `,
          confirmButtonText: 'Update',
          focusConfirm: false,
          preConfirm: () => {
            const data = {
              product_name: document.getElementById('swal_name').value,
              selling_price: parseFloat(document.getElementById('swal_price').value),
              offer_quantity: parseInt(document.getElementById('swal_offer').value),
              dimensions: document.getElementById('swal_dim').value,
              status: document.getElementById('swal_status').value
            };

            return fetch(`/product/update/${r.id}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
              },
              body: JSON.stringify(data)
            }).then(res => {
              if (!res.ok) throw new Error('Failed to update');
              return res.json();
            }).then(() => {
              Swal.fire('Updated!', 'Product updated successfully.', 'success').then(() => location.reload());
            }).catch(err => {
              Swal.showValidationMessage(`Request failed: ${err}`);
            });
          }
        });
      };

      // Delete product
      tr.querySelector('.deleteBtn').onclick = () => {
        Swal.fire({
          title: `Delete Product #${r.id}?`,
          text: 'This action cannot be undone.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(result => {
          if (result.isConfirmed) {
            fetch(`/product/${r.id}`, {
              method: 'DELETE',
              headers: {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
              }
            }).then(res => {
              if (!res.ok) throw new Error('Failed to delete');
              Swal.fire('Deleted!', 'Product has been deleted.', 'success').then(() => location.reload());
            }).catch(err => {
              Swal.fire('Error!', `Delete failed: ${err}`, 'error');
            });
          }
        });
      };

      tbody.appendChild(tr);
    });

    lucide.createIcons();
  }

  function updateStatus(id, sel, oldVal) {
    const token = localStorage.getItem('authToken');
    fetch(`${BASE}/admin/product_toggle_status`, {
      method : 'POST',
      headers: {'Content-Type':'application/json',
                'Authorization':`Bearer ${token}`},
      body   : JSON.stringify({product_id:id, product_status:sel.value})
    })
    .then(r=>r.json())
    .then(j=>{ if(!j.success) throw 0; alert('Status updated'); })
    .catch(_=>{ alert('Failed'); sel.value=oldVal; });
  }

  /* ───────────────────────── PAGINATION ───────────────────────────── */
  function renderPager() {
    const nav = $('#pagination'); nav.innerHTML='';
    const pages = Math.max(1, Math.ceil(totalRows/pageSize));

    const btn = (lab,page,dis=false)=>{
      const b=document.createElement('button');
      b.textContent=lab; b.dataset.page=page; b.disabled=dis;
      b.className = `px-3 py-1.5 rounded-md border transition ${
        page===current?'bg-red-600 text-white border-red-600'
                      :'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
      } ${dis?'opacity-50 cursor-not-allowed':''}`; return b;
    };
    nav.appendChild(btn('Prev',Math.max(1,current-1),current===1));
    for(let p=1;p<=pages;p++) nav.appendChild(btn(p,p));
    nav.appendChild(btn('Next',Math.min(pages,current+1),current===pages));
  }

  /* ──────────────────────── EVENT HOOKS ───────────────────────────── */
  $('#applyFilters').onclick = () => { current=1; fetchProducts(); };
  $('#pagination').onclick   = e=>{
    if(e.target.tagName==='BUTTON' && !e.target.disabled){
      current = +e.target.dataset.page; fetchProducts();
    }
  };

  /* ────────────────────────── BOOTSTRAP ───────────────────────────── */
  (async () => {
    await buildCheckList({
      url     : IDS_URL,
      wrapEl  : $('#industryList'),
      cls     : 'industryChk',
      valueSel: i=>i.id,
      labelSel: i=>i.name
    });
    await buildCheckList({
      url     : SUB_URL,
      wrapEl  : $('#subIndustryList'),
      cls     : 'subChk',
      valueSel: s=>s.id,
      labelSel: s=>s.name
    });
    await buildCheckList({
      url     : USERS_URL,
      body    : {limit:100, offset:0},         // ← POST payload
      wrapEl  : $('#userList'),
      cls     : 'userChk',
      valueSel: u=>u.user_id,                  // skip nulls
      labelSel: u=>u.name || u.username
    });

    attachSearch('#industrySearch','#industryList');
    attachSearch('#subIndustrySearch','#subIndustryList');
    attachSearch('#userSearch','#userList');

    fetchProducts();                          // first load
  })();
</script>


