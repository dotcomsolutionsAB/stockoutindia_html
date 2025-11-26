<div id="view-product-by-user" class="tab-content">
  <!-- ▼▼  TAB: View Product by User  ▼▼ -->
  <h2 class="text-2xl font-semibold text-red-600 mb-6">View Product by User</h2>

  <!-- ░░ FILTER BAR ░░ -->
  <section class="bg-white shadow rounded-2xl p-3 flex flex-wrap gap-4 items-end border border-red-200">

    <!-- User IDs -->
    <div class="flex flex-col gap-1">
      <input id="up-userIds" type="text"
        placeholder="Search User IDs (comma) e.g. 1,6,5"
        class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-64 focus:ring-red-500 focus:border-red-500">
    </div>

    <!-- Email -->
    <div class="flex flex-col gap-1">
      <input id="up-email" type="text"
        placeholder="Search Email"
        class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-56 focus:ring-red-500 focus:border-red-500">
    </div>

    <!-- Phone -->
    <div class="flex flex-col gap-1">
      <input id="up-phone" type="text"
        placeholder="Search Phone"
        class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-48 focus:ring-red-500 focus:border-red-500">
    </div>

    <!-- Active Status -->
    <div class="flex flex-col gap-1">
      <select id="up-isActive"
        class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-36 focus:ring-red-500 focus:border-red-500">
        <option value="">All Status</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>

    <!-- Sort -->
    <div class="flex flex-col gap-1">
      <select id="up-sortOrder"
        class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-40 focus:ring-red-500 focus:border-red-500">
        <option value="desc" selected>Newest (Created)</option>
        <option value="asc">Oldest (Created)</option>
      </select>
    </div>

    <!-- Rows per page -->
    <div class="flex flex-col gap-1">
      <select id="up-rowsPerPage"
        class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-24 focus:ring-red-500 focus:border-red-500">
        <option value="">Show</option>
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
      <thead class="text-xs uppercase tracking-wider bg-red-800 text-red-200 border-b-2 border-red-600">
        <tr>
          <th class="px-6 py-3 text-left w-1/5">Name</th>
          <th class="px-6 py-3 text-left w-1/4">Email</th>
          <th class="px-6 py-3 text-left">Products</th>
          <!-- 🔥 New Column -->
          <th class="px-6 py-3 text-center w-28">Logged In</th>
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
      <!-- 🔥 New Logged In Column -->
      <td class="px-6 py-4 text-center" data-f="loggedin">
          <button class="loginBtn bg-red-500 hover:bg-red-400 text-white px-3 py-1 rounded-md text-xs">
              Login as User
          </button>
      </td>
      <td class="px-6 py-4 text-center space-x-1">
        <button
          class="viewBtn w-8 h-8 rounded-full bg-red-500 hover:bg-red-400 text-white inline-flex items-center justify-center"
          title="View"><i data-lucide="eye"></i></button>
        <button
          class="editBtn w-8 h-8 rounded-full bg-red-500 hover:bg-red-400 text-white inline-flex items-center justify-center"
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
      const API_URLs = `<?php echo BASE_URL; ?>/admin/fetch_user`;

      let limit = 10;
      let offset = 0;
      let total = 0;

      let userIdsCSV = '';
      let emailFilter = '';
      let phoneFilter = '';
      let isActiveFilter = '';
      let sortBy = 'created_at';
      let sortOrder = 'desc';

      const rupee = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 0
      });

      const debounce = (fn, ms = 300) => {
        let t;
        return (...a) => {
          clearTimeout(t);
          t = setTimeout(() => fn(...a), ms);
        };
      };

      /* ---------- FETCH ---------- */
      async function fetchUsersProducts() {
        const token = localStorage.getItem('authToken');

        const body = {
          limit,
          offset,
          sort_by: sortBy,
          sort_order: sortOrder,
          email: emailFilter,
          phone: phoneFilter,
          is_active: isActiveFilter
        };

        if (userIdsCSV) {
          body.ids = userIdsCSV;
        }

        try {
          const res = await fetch(API_URLs, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              Authorization: `Bearer ${token}`
            },
            body: JSON.stringify(body)
          });

          const json = await res.json();

          if (!json.success) throw new Error('API error');

          const rows = Array.isArray(json.data) ? json.data : [];
          total = json.total_count ?? rows.length;

          renderTable(rows);
        } catch (e) {
          console.error('fetchUsersProducts error:', e);
          total = 0;
          renderTable([]);
        }

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
          const frag = tmpl.content.cloneNode(true);

          frag.querySelector('[data-f="name"]').textContent =
            u.name || u.company_name || '—';
          frag.querySelector('[data-f="email"]').textContent =
            u.email || u.username || '—';

          const cell = frag.querySelector('[data-f="products"]');

          if (u.products && u.products.length) {
            const list = document.createElement('ul');
            list.className = 'space-y-1';

            u.products.forEach(p => {
              const li = document.createElement('li');

              const price = (p.selling_price != null && p.selling_price !== '')
                ? rupee.format(Number(p.selling_price))
                : '';

              li.innerHTML = `
                <div class="flex items-start gap-2">
                  <span class="font-medium">${p.name ?? 'Unnamed Product'}</span>
                  ${price ? `<span class="text-gray-500">${price}</span>` : ''}
                </div>
                <div class="text-xs text-gray-500 ml-1">
                  ${(p.industry && p.industry.name) ? p.industry.name : (u.industry?.name ?? '')}
                  ${' › '}
                  ${(p.sub_industry && p.sub_industry.name) ? p.sub_industry.name : (u.sub_industry?.name ?? '')}
                </div>`;
              list.appendChild(li);
            });

            // show active product count if present
            if (typeof u.active_product_count === 'number') {
              const countTag = document.createElement('div');
              countTag.className = 'text-xs text-gray-600 mt-1';
              countTag.textContent = `Active products: ${u.active_product_count}`;
              list.appendChild(countTag);
            }

            cell.appendChild(list);
          } else {
            const meta = [];
            if (u.industry?.name) meta.push(u.industry.name);
            if (u.sub_industry?.name) meta.push(u.sub_industry.name);
            if (typeof u.active_product_count === 'number') {
              meta.push(`Active products: ${u.active_product_count}`);
            }

            cell.innerHTML = `
              <div class="text-gray-400">No products</div>
              ${meta.length ? `<div class="text-xs text-gray-500 mt-1">${meta.join(' · ')}</div>` : ''}
            `;
          }

          // Actions
          frag.querySelector('.viewBtn').onclick = () => {
            alert('View user ' + u.id);
          };
          frag.querySelector('.editBtn').onclick = () => {
            alert('Edit user ' + u.id);
          };
          frag.querySelector('.deleteBtn').onclick = () => {
            if (confirm('Delete user ' + u.id + '?')) {
              alert('Delete API here');
            }
          };
          /* 🔥 ADD THIS BELOW THE ACTIONS INSIDE renderTable() */
          // frag.querySelector('.loginBtn').onclick = () => {
          //   const url = `<?php echo BASE_URL; ?>/admin_login?user_id=${u.id}`;
          //   window.open(url, "_blank");  // or redirect same page
          // };
          frag.querySelector('.loginBtn').onclick = async () => {
            const token = localStorage.getItem("authToken");

            try {
                // 🔥 1. LOGOUT API CALL FIRST
                await fetch(`<?php echo BASE_URL; ?>/logout`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${token}`
                    }
                });

                // 🔥 2. CLEAR ALL LOCALSTORAGE CREDENTIALS
                localStorage.removeItem("authToken");
                localStorage.removeItem("user_id");
                localStorage.removeItem("role");
                localStorage.removeItem("username");
                localStorage.removeItem("name");

                // 🔥 3. REDIRECT TO ADMIN LOGIN AS THAT USER
                const FRONT_URL = "https://stockoutindia.com";   // your frontend web domain
                const url = `${FRONT_URL}/admin_login?user_id=${u.id}`;
                window.location.href = url; // open same tab (recommended)

            } catch (err) {
                console.error("Logout failed:", err);
                alert("Logout failed — check API");
            }
          };


          tbody.appendChild(frag);
        });

        if (window.lucide) {
          lucide.createIcons();
        }
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
          b.textContent = lbl;
          b.dataset.p = p;
          b.disabled = dis;
          b.className =
            `px-3 py-1.5 rounded-md border transition ${p === current
              ? 'bg-red-600 text-white border-red-600'
              : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
            } ${dis ? 'opacity-50 cursor-not-allowed' : ''}`;
          return b;
        };

        nav.appendChild(btn('Prev', current - 1, current === 1));

        const visiblePages = Math.min(showPages, pages);
        for (let p = 1; p <= visiblePages; p++) {
          nav.appendChild(btn(p, p));
        }

        nav.appendChild(btn('Next', current + 1, current === pages));
      }

      document.getElementById('up-pagination')
        .addEventListener('click', e => {
          if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
            offset = (Number(e.target.dataset.p) - 1) * limit;
            fetchUsersProducts();
          }
        });

      /* ---------- EVENTS: FILTERS ---------- */

      // User IDs (comma separated)
      document.getElementById('up-userIds')
        .addEventListener('input', debounce(e => {
          userIdsCSV = e.target.value.replace(/\s+/g, '');
          offset = 0;
          fetchUsersProducts();
        }, 300));

      // Email
      document.getElementById('up-email')
        .addEventListener('input', debounce(e => {
          emailFilter = e.target.value.trim();
          offset = 0;
          fetchUsersProducts();
        }, 300));

      // Phone
      document.getElementById('up-phone')
        .addEventListener('input', debounce(e => {
          phoneFilter = e.target.value.trim();
          offset = 0;
          fetchUsersProducts();
        }, 300));

      // Active status
      document.getElementById('up-isActive')
        .addEventListener('change', e => {
          isActiveFilter = e.target.value; // '' / '1' / '0'
          offset = 0;
          fetchUsersProducts();
        });

      // Sort order
      document.getElementById('up-sortOrder')
        .addEventListener('change', e => {
          sortOrder = e.target.value === 'asc' ? 'asc' : 'desc';
          offset = 0;
          fetchUsersProducts();
        });

      // Rows per page
      document.getElementById('up-rowsPerPage')
        .addEventListener('change', e => {
          const value = Number(e.target.value);
          limit = (!value || isNaN(value)) ? 10 : value;
          offset = 0;
          fetchUsersProducts();
        });

      /* ---------- INIT ---------- */
      fetchUsersProducts();
    })();
  </script>
  <!-- ▲▲  END TAB  ▲▲ -->
</div>
