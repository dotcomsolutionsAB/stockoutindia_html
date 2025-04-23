<div id="view-order-by-user" class="tab-content">
  <h2 class="text-2xl font-semibold text-red-600 mb-6">
    View Orders by User
  </h2>

  <!-- ░░ FILTER BAR ░░ -->
  <section class="bg-white shadow rounded-2xl p-3 flex flex-wrap gap-4 items-end border border-red-200">

    <!-- User name search (≥2 chars) -->
    <div class="flex flex-col gap-1 relative">
      <!-- <label for="uo-search" class="font-medium text-gray-700">User Name</label> -->
      <input id="uo-search" type="text" autocomplete="off" placeholder="Typing User Name" class="w-56 bg-gray-50 border border-red-300 rounded-lg p-2.5
                    focus:ring-red-500 focus:border-red-500">
      <ul id="uo-suggest" class="absolute z-10 mt-1 w-full bg-white border border-gray-300
                 rounded-md shadow-lg max-h-48 overflow-y-auto hidden"></ul>
    </div>

    <!-- Rows‑per‑page -->
    <div class="flex flex-col gap-1">
      <!-- <label for="uo-rows" class="font-medium text-gray-700">Show</label> -->
      <select id="uo-rows" class="bg-gray-50 border border-red-300 rounded-lg p-2.5 w-24
                     focus:ring-red-500 focus:border-red-500">
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
          <th class="px-6 py-3 text-left">Name</th>
          <!-- <th class="px-6 py-3 text-left">Email</th> -->
          <th class="px-6 py-3 text-center">Order #</th>
          <th class="px-6 py-3 text-center">Date</th>
          <th class="px-6 py-3 text-center">Status</th>
          <th class="px-6 py-3 text-center">Amount</th>
          <th class="px-6 py-3 text-center w-32">Actions</th>
        </tr>
      </thead>
      <tbody id="uo-body" class="divide-y divide-gray-100 bg-white"></tbody>
    </table>
  </section>

  <!-- ░░ FOOTER ░░ -->
  <footer class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-gray-700 mt-4">
    <div id="uo-count">0 results</div>
    <nav id="uo-page" class="flex items-center gap-2"></nav>
  </footer>

  <!-- ░░ ROW TEMPLATE ░░ -->
  <template id="uo-tmpl">
    <tr class="hover:bg-gray-50">
      <td class="px-6 py-4 font-medium text-gray-900">
        <div class="flex flex-col div">
          <span class="name " data-f="name"></span>
          <span class="email text-red-900" data-f="email"></span>
        </div>
      </td>
      <td class="px-6 py-4 text-center">
        <div class="flex flex-col div2">
          <span class="name " data-f="oid"></span>
          <span class="email text-red-900" data-f="razor-pay-id"></span>
        </div>
      </td>
      <td class="px-6 py-4 text-center" data-f="date"></td>
      <td class="px-6 py-4 text-center" data-f="status"></td>
      <td class="px-6 py-4 text-center" data-f="amount"></td>
      <td class="px-6 py-4 text-center space-x-1">
        <button class="view w-8 h-8 rounded-full bg-red-500 hover:bg-red-400
                       text-white inline-flex items-center justify-center" title="View">
          <i data-lucide="eye"></i>
        </button>
        <button class="edit w-8 h-8 rounded-full bg-red-500 hover:bg-red-400
                       text-white inline-flex items-center justify-center" title="Edit">
          <i data-lucide="pencil"></i>
        </button>
        <button class="del  w-8 h-8 rounded-full bg-red-600 hover:bg-red-500
                       text-white inline-flex items-center justify-center" title="Delete">
          <i data-lucide="trash-2"></i>
        </button>
      </td>
    </tr>
  </template>

  <!-- <script>
    (() => {
      lucide.createIcons();

      /* ---------- CONFIG ---------- */
      const BASE_URL = '<?php echo BASE_URL; ?>';
      const ORDERS_API = `${BASE_URL}/admin/user_orders`;

      /* ---------- STATE ---------- */
      let limit = 10;
      let offset = 0;
      let total = 0;
      let selectedUserId = null;
      let cachedUsers = [];      // one‑time cache for suggestions

      /* ---------- HELPERS ---------- */
      const rupee = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 });
      const debounce = (fn, ms = 300) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms) } };

      /* ---------- USER SUGGESTIONS ---------- */
      async function loadUsersForSuggest() {
        if (cachedUsers.length) return;
        // single bulk call
        const token = localStorage.getItem('authToken');
        const res = await fetch(ORDERS_API, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}` },
          body: JSON.stringify({ limit: 100000, offset: 0 })
        });
        const json = await res.json();
        if (!json.success) return;
        const seen = new Set();
        cachedUsers = json.data
          .map(d => d.user)
          .filter(u => u && !seen.has(u.id) && seen.add(u.id));
      }

      function showSuggestions(term) {
        const box = document.getElementById('uo-suggest');
        box.innerHTML = '';
        if (term.length < 2) { box.classList.add('hidden'); return; }
        const low = term.toLowerCase();
        cachedUsers.filter(u => u.name.toLowerCase().includes(low)).slice(0, 25).forEach(u => {
          const li = document.createElement('li');
          li.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
          li.textContent = `${u.name} (ID ${u.id})`;
          li.onclick = () => {
            document.getElementById('uo-search').value = u.name;
            selectedUserId = u.id; box.classList.add('hidden'); fetchOrders();
          };
          box.appendChild(li);
        });
        box.classList.toggle('hidden', box.childElementCount === 0);
      }

      document.getElementById('uo-search')
        .addEventListener('input', debounce(async e => {
          const term = e.target.value.trim();

          // always clear currently‑selected user until a suggestion is chosen
          selectedUserId = null;

          // if the box is blank (or <2 chars) => fetch *all* orders
          if (term.length < 2) {
            document.getElementById('uo-suggest').classList.add('hidden');
            offset = 0;
            fetchOrders();
            return;
          }

          // otherwise show suggestion dropdown
          await loadUsersForSuggest();
          showSuggestions(term);
        }, 200));


      document.addEventListener('click', e => {
        if (!document.getElementById('uo-suggest').contains(e.target)
          && e.target.id !== 'uo-search') {
          document.getElementById('uo-suggest').classList.add('hidden');
        }
      });

      /* ---------- FETCH ORDERS ---------- */
      async function fetchOrders() {
        const token = localStorage.getItem('authToken');
        const body = { limit, offset };
        if (selectedUserId) body.user_id = selectedUserId;

        try {
          const res = await fetch(ORDERS_API, {
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
        document.getElementById('uo-count').textContent =
          `${total} result${total !== 1 ? 's' : ''}`;
      }

      /* ---------- TABLE ---------- */
      function renderTable(rows) {
        const body = document.getElementById('uo-body');
        body.innerHTML = '';
        const tmpl = document.getElementById('uo-tmpl');

        rows.forEach(item => {
          const tr = tmpl.content.cloneNode(true);
          const u = item.user || { name: '—', email: '—' };
          const o = item.orders || {};

          tr.querySelector('[data-f="name"]').textContent = u.name;
          tr.querySelector('[data-f="email"]').textContent = u.email;
          tr.querySelector('[data-f="oid"]').textContent = o.order_id ?? '–';
          tr.querySelector('[data-f="razor-pay-id"]').textContent = o.razorpay_order_id ?? '–';
          tr.querySelector('[data-f="date"]').textContent = o.date ?? '–';
          // tr.querySelector('[data-f="amount"]').textContent = o.amount ?? '–';
          tr.querySelector('[data-f="amount"]').textContent = o.amount != null ? rupee.format(o.amount) : '–';

          const st = o.status ?? '–';
          tr.querySelector('[data-f="status"]').innerHTML =
            `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold ${st === 'created' ? 'bg-yellow-100 text-yellow-800' :
              st === 'paid' ? 'bg-green-100 text-green-800' :
                'bg-gray-100 text-gray-700'
            }">${st}</span>`;

          tr.querySelector('[data-f="date"]').textContent = o.date ?? '–';
          tr.querySelector('.view').onclick = () => alert('View order ' + o.order_id);
          tr.querySelector('.edit').onclick = () => alert('Edit order ' + o.order_id);
          tr.querySelector('.del').onclick = () => { if (confirm('Delete order ' + o.order_id + '?')) alert('delete API'); };

          body.appendChild(tr);
        });
        lucide.createIcons();
      }

      /* ---------- PAGINATION ---------- */
      function renderPagination() {
        const nav = document.getElementById('uo-page');
        nav.innerHTML = '';
        const current = Math.floor(offset / limit) + 1;
        const pages = Math.max(1, Math.ceil(total / limit));

        const btn = (lbl, p, dis = false) => {
          const b = document.createElement('button');
          b.textContent = lbl; b.dataset.p = p; b.disabled = dis;
          b.className = `px-3 py-1.5 rounded-md border transition ${p === current ? 'bg-red-600 text-white border-red-600' :
              'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
            } ${dis ? 'opacity-50 cursor-not-allowed' : ''}`;
          return b;
        };

        nav.appendChild(btn('Prev', current - 1, current === 1));
        for (let p = 1; p <= Math.min(5, pages); p++) nav.appendChild(btn(p, p));
        nav.appendChild(btn('Next', current + 1, current === pages));
      }
      document.getElementById('uo-page').addEventListener('click', e => {
        if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
          offset = (Number(e.target.dataset.p) - 1) * limit; fetchOrders();
        }
      });

      /* ---------- EVENTS ---------- */
      document.getElementById('uo-rows').addEventListener('change', () => {
        limit = Number(document.getElementById('uo-rows').value); offset = 0; fetchOrders();
      });

      /* ---------- INIT ---------- */
      fetchOrders();
    })();
  </script> -->
<script>
  (() => {
    lucide.createIcons();               /* (re-run after each render) */

    /* ---------- CONFIG ---------- */
    const BASE_URL   = '<?php echo BASE_URL; ?>';
    const ORDERS_API = `${BASE_URL}/admin/user_orders`;

    /* ---------- STATE ---------- */
    let limit  = 10;
    let offset = 0;
    let total  = 0;
    let selectedUserId = null;
    let cachedUsers    = [];            // populated once for suggestions

    /* ---------- HELPERS ---------- */
    const rupee    = new Intl.NumberFormat('en-IN', { style:'currency', currency:'INR', maximumFractionDigits:0 });
    const debounce = (fn, ms=300) => { let t; return (...a) => { clearTimeout(t); t=setTimeout(() => fn(...a), ms); }; };

    /* ---------- USER SUGGESTIONS ---------- */
    async function loadUsersForSuggest () {
      if (cachedUsers.length) return;   // already cached

      const token = localStorage.getItem('authToken');
      const res   = await fetch(ORDERS_API, {
        method : 'POST',
        headers: { 'Content-Type':'application/json', Authorization:`Bearer ${token}` },
        body   : JSON.stringify({ limit:100_000, offset:0 })
      });

      const json = await res.json();
      if (!json.success || !Array.isArray(json.data)) return;

      const seen = new Set();
      cachedUsers = json.data
        .map(d => d.user)
        .filter(u => u && u.id && !seen.has(u.id) && (seen.add(u.id), true));
    }

    function showSuggestions (term) {
      const box = document.getElementById('uo-suggest');
      box.innerHTML = '';

      /* hide list when < 3 chars */
      if (term.length < 3) { box.classList.add('hidden'); return; }

      const lowTerm = term.toLowerCase();

      cachedUsers
        .filter(u => (u.name || '').toLowerCase().includes(lowTerm))
        .slice(0, 25)
        .forEach(u => {
          const li      = document.createElement('li');
          li.className  = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
          li.textContent= `${u.name || 'No Name'} (ID ${u.id})`;
          li.onclick    = () => {
            document.getElementById('uo-search').value = u.name || '';
            selectedUserId = u.id;
            box.classList.add('hidden');
            offset = 0;
            fetchOrders();
          };
          box.appendChild(li);
        });

      box.classList.toggle('hidden', box.childElementCount === 0);
    }

    /* ---------- INPUT HANDLER ---------- */
    document.getElementById('uo-search')
      .addEventListener('input', debounce(async e => {
        const term = e.target.value.trim();

        // reset chosen user until a suggestion is explicitly picked
        selectedUserId = null;

        /* when the field is < 3 chars → treat as “show all orders” */
        if (term.length < 3) {
          document.getElementById('uo-suggest').classList.add('hidden');
          offset = 0;
          fetchOrders();
          return;
        }

        await loadUsersForSuggest();
        showSuggestions(term);
      }, 200));

    /* close suggestion list on outside click */
    document.addEventListener('click', e => {
      if (!document.getElementById('uo-suggest').contains(e.target) &&
          e.target.id !== 'uo-search') {
        document.getElementById('uo-suggest').classList.add('hidden');
      }
    });

    /* ---------- FETCH ORDERS ---------- */
    async function fetchOrders () {
      const token = localStorage.getItem('authToken');
      const body  = { limit, offset };
      if (selectedUserId) body.user_id = selectedUserId;

      try {
        const res  = await fetch(ORDERS_API, {
          method : 'POST',
          headers: { 'Content-Type':'application/json', Authorization:`Bearer ${token}` },
          body   : JSON.stringify(body)
        });

        const json = await res.json();
        if (!json.success) throw new Error();

        total = json.total_count ?? json.data.length;
        renderTable(json.data);
      } catch {
        total = 0;
        renderTable([]);
      }

      renderPagination();
      document.getElementById('uo-count').textContent =
        `${total} result${total !== 1 ? 's' : ''}`;
    }

    /* ---------- TABLE RENDER ---------- */
    function renderTable (rows) {
      const body = document.getElementById('uo-body');
      body.innerHTML = '';
      const tmpl = document.getElementById('uo-tmpl');

      rows.forEach(item => {
        const tr = tmpl.content.cloneNode(true);
        const u  = item.user   ?? { name:'—', email:'—' };
        const o  = item.orders ?? {};

        tr.querySelector('[data-f="name"]').textContent  = u.name  ?? '—';
        tr.querySelector('[data-f="email"]').textContent = u.email ?? '—';
        tr.querySelector('[data-f="oid"]').textContent   = o.order_id          ?? '–';
        tr.querySelector('[data-f="razor-pay-id"]').textContent = o.razorpay_order_id ?? '–';
        tr.querySelector('[data-f="date"]').textContent        = o.date   ?? '–';
        tr.querySelector('[data-f="amount"]').textContent      = o.amount != null ? rupee.format(o.amount) : '–';

        const st = o.status ?? '–';
        tr.querySelector('[data-f="status"]').innerHTML =
          `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold ${
              st==='created' ? 'bg-yellow-100 text-yellow-800' :
              st==='paid'    ? 'bg-green-100 text-green-800'  :
                              'bg-gray-100 text-gray-700'
          }">${st}</span>`;

        /* demo buttons */
        tr.querySelector('.view').onclick = () => alert('View order '  + (o.order_id ?? ''));
        tr.querySelector('.edit').onclick = () => alert('Edit order '  + (o.order_id ?? ''));
        tr.querySelector('.del' ).onclick = () => {
          if (confirm('Delete order ' + (o.order_id ?? '') + '?')) alert('delete API');
        };

        body.appendChild(tr);
      });

      lucide.createIcons();            // refresh icons inside new rows
    }

    /* ---------- PAGINATION ---------- */
    function renderPagination () {
      const nav     = document.getElementById('uo-page');
      nav.innerHTML = '';

      const current = Math.floor(offset / limit) + 1;
      const pages   = Math.max(1, Math.ceil(total / limit));

      const makeBtn = (lbl, p, disabled=false) => {
        const b = document.createElement('button');
        b.textContent = lbl;
        b.dataset.p   = p;
        b.disabled    = disabled;
        b.className   = `px-3 py-1.5 rounded-md border transition ${
            p===current ? 'bg-red-600 text-white border-red-600' :
                          'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
          } ${disabled ? 'opacity-50 cursor-not-allowed' : ''}`;
        return b;
      };

      nav.appendChild(makeBtn('Prev', current-1, current===1));

      /* show up to 5 page numbers (can be tweaked) */
      const start = Math.max(1, current - 2);
      const end   = Math.min(pages, start + 4);
      for (let p = start; p <= end; p++) nav.appendChild(makeBtn(p, p));

      nav.appendChild(makeBtn('Next', current+1, current===pages));
    }

    /* page-button click */
    document.getElementById('uo-page').addEventListener('click', e => {
      if (e.target.tagName === 'BUTTON' && !e.target.disabled) {
        offset = (Number(e.target.dataset.p) - 1) * limit;
        fetchOrders();
      }
    });

    /* rows-per-page change */
    document.getElementById('uo-rows').addEventListener('change', () => {
      limit  = Number(document.getElementById('uo-rows').value) || 10;
      offset = 0;
      fetchOrders();
    });

    /* ---------- INIT ---------- */
    fetchOrders();
  })();
</script>

</div>