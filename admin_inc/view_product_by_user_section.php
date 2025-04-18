<div id="view-product-by-user" class="tab-content">
  <!-- ▼▼  TAB: View Product by User  ▼▼ -->
  <h2 class="text-2xl font-semibold text-red-600 mb-6">View Product by User</h2>

  <!-- ░░ FILTER BAR ░░ -->
  <section class="bg-white shadow rounded-2xl p-6 flex flex-wrap gap-4 items-end border border-red-200">

    <div class="flex flex-col gap-1">
      <label for="up-userIds" class="font-medium text-gray-700">User IDs <span
          class="text-xs text-gray-500">(comma)</span></label>
      <input id="up-userIds" type="text" placeholder="e.g. 1,6,5" class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-64
                    focus:ring-red-500 focus:border-red-500">
    </div>

    <div class="flex flex-col gap-1">
      <label for="up-rowsPerPage" class="font-medium text-gray-700">Show</label>
      <select id="up-rowsPerPage" class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-24
                     focus:ring-red-500 focus:border-red-500">
        <option value="10" selected>10</option>
        <option value="20">20</option>
        <option value="40">40</option>
        <option value="50">50</option>
      </select>
    </div>
  </section>

  <!-- ░░ TABLE ░░ -->
  <section class="bg-white shadow rounded-2xl overflow-x-auto mt-6">
    <table class="min-w-full divide-y divide-red-200">
      <thead class="bg-red-50/30 text-xs uppercase tracking-wider text-red-700 border-b-2 border-red-600">
        <tr>
          <th class="px-6 py-3 text-left w-1/5">Name</th>
          <th class="px-6 py-3 text-left w-1/4">Email</th>
          <th class="px-6 py-3 text-left">Products</th>
          <th class="px-6 py-3 text-center w-32">Actions</th>
        </tr>
      </thead>
      <tbody id="up-tableBody" class="divide-y divide-gray-100 bg-white"></tbody>
    </table>
  </section>

  <!-- ░░ FOOTER ░░ -->
  <footer class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-gray-700 mt-4">
    <div id="up-resultCount">0 results</div>
    <nav id="up-pagination" class="flex items-center gap-2"></nav>
  </footer>

  <!-- ░░ ROW TEMPLATE ░░ -->
  <template id="up-rowTemplate">
    <tr class="hover:bg-gray-50">
      <td class="px-6 py-4 font-medium text-gray-900" data-f="name"></td>
      <td class="px-6 py-4 break-all text-gray-700" data-f="email"></td>
      <td class="px-6 py-4" data-f="products"></td>
      <td class="px-6 py-4 text-center space-x-1">
        <button
          class="viewBtn   w-8 h-8 rounded-full bg-red-500 hover:bg-red-400 text-white inline-flex items-center justify-center"
          title="View"><i data-lucide="eye"></i></button>
        <button
          class="editBtn   w-8 h-8 rounded-full bg-red-500 hover:bg-red-400 text-white inline-flex items-center justify-center"
          title="Edit"><i data-lucide="pencil"></i></button>
        <button
          class="deleteBtn w-8 h-8 rounded-full bg-red-600 hover:bg-red-500 text-white inline-flex items-center justify-center"
          title="Delete"><i data-lucide="trash-2"></i></button>
      </td>
    </tr>
  </template>

  <!-- ░░ SCRIPT ░░ -->
  <script>
    (() => {
      const BASE_URL = '<?php echo BASE_URL; ?>';
      const API_URL = `${BASE_URL}/admin/users_with_products`;

      let limit = 10;
      let offset = 0;
      let total = 0;
      let userIdsCSV = '';

      const rupee = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 });
      const debounce = (fn, ms = 300) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms) } };

      /* ---------- FETCH ---------- */
      async function fetchUsersProducts() {
        const token = localStorage.getItem('authToken');
        const body = { limit, offset };
        if (userIdsCSV) body.user_ids = userIdsCSV;

        try {
          const res = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}` },
            body: JSON.stringify(body)
          });
          const json = await res.json();
          if (!json.success) throw 0;
          total = json.total_count || json.data.length;
          renderTable(json.data);
        } catch { total = 0; renderTable([]); }
        renderPagination();
        document.getElementById('up-resultCount').textContent =
          `${total} result${total !== 1 ? 's' : ''}`;
      }

      /* ---------- TABLE ---------- */
      function renderTable(rows) {
        const tbody = document.getElementById('up-tableBody');
        tbody.innerHTML = '';
        const tmpl = document.getElementById('up-rowTemplate');

        rows.forEach(u => {
          const tr = tmpl.content.cloneNode(true);
          tr.querySelector('[data-f="name"]').textContent = u.name ?? '—';
          tr.querySelector('[data-f="email"]').textContent = u.email ?? '—';

          const cell = tr.querySelector('[data-f="products"]');
          if (u.products?.length) {
            const list = document.createElement('ul'); list.className = 'space-y-1';
            u.products.forEach(p => {
              const li = document.createElement('li');
              li.innerHTML = `
              <div class="flex items-start gap-2">
                <span class="font-medium">${p.name ?? 'Unnamed Product'}</span>
                <span class="text-gray-500">${rupee.format(p.selling_price)}</span>
              </div>
              <div class="text-xs text-gray-500 ml-1">
                ${p.industry?.name ?? ''} › ${p.sub_industry?.name ?? ''}
              </div>`;
              list.appendChild(li);
            });
            cell.appendChild(list);
          } else cell.innerHTML = '<span class="text-gray-400">No products</span>';

          tr.querySelector('.viewBtn').onclick = () => alert('View user ' + u.id);
          tr.querySelector('.editBtn').onclick = () => alert('Edit user ' + u.id);
          tr.querySelector('.deleteBtn').onclick = () => {
            if (confirm('Delete user ' + u.id + '?')) alert('Delete API here');
          };
          tbody.appendChild(tr);
        });
        lucide.createIcons();
      }

      /* ---------- PAGINATION ---------- */
      const showPages = 5;
      function renderPagination() {
        const nav = document.getElementById('up-pagination');
        nav.innerHTML = '';
        const current = Math.floor(offset / limit) + 1;
        const pages = Math.max(1, Math.ceil(total / limit));

        const btn = (lbl, p, dis = false) => {
          const b = document.createElement('button');
          b.textContent = lbl; b.dataset.p = p; b.disabled = dis;
          b.className = `px-3 py-1.5 rounded-md border transition ${p === current ? 'bg-red-600 text-white border-red-600' :
              'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
            } ${dis ? 'opacity-50 cursor-not-allowed' : ''}`; return b;
        };

        nav.appendChild(btn('Prev', current - 1, current === 1));
        for (let p = 1; p <= Math.min(showPages, pages); p++)
          nav.appendChild(btn(p, p));
        nav.appendChild(btn('Next', current + 1, current === pages));
      }
      document.getElementById('up-pagination')
        .addEventListener('click', e => {
          if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
            offset = (Number(e.target.dataset.p) - 1) * limit;
            fetchUsersProducts();
          }
        });

      /* ---------- EVENTS ---------- */
      document.getElementById('up-userIds')
        .addEventListener('input', debounce(e => {
          userIdsCSV = e.target.value.replace(/\s+/g, '');
          offset = 0; fetchUsersProducts();
        }, 300));

      document.getElementById('up-rowsPerPage')
        .addEventListener('change', () => {
          limit = Number(document.getElementById('up-rowsPerPage').value);
          offset = 0; fetchUsersProducts();
        });

      /* ---------- INIT ---------- */
      fetchUsersProducts();
    })();
  </script>
  <!-- ▲▲  END TAB  ▲▲ -->

</div>