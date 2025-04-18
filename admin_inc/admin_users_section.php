<div id="view-user-orders" class="tab-content">
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">View User Orders</h1>

        <!-- ╭─ FILTER BAR ──────────────────────────────────────────────────────╮ -->
        <section
            class="bg-white shadow rounded-2xl p-6 flex flex-wrap gap-4 items-end">

            <!-- User Name search -->
            <div class="flex flex-col gap-1 relative">
            <label for="userSearch" class="font-medium text-gray-700">User Name</label>
            <input id="userSearch" type="text" autocomplete="off" placeholder="Start typing…"
                    class="w-56 bg-gray-50 border border-gray-300 rounded-lg p-2.5
                            focus:ring-red-500 focus:border-red-500">
            <!-- dropdown suggestions -->
            <ul id="userSuggest"
                class="absolute z-10 mt-1 w-full bg-white border border-gray-300
                        rounded-md shadow-lg max-h-48 overflow-y-auto hidden"></ul>
            </div>

            <!-- Rows‑per‑page -->
            <div class="flex flex-col gap-1">
            <label for="rowsPerPage" class="font-medium text-gray-700">Show</label>
            <select id="rowsPerPage"
                    class="bg-gray-50 border border-gray-300 rounded-lg p-2.5
                            focus:ring-red-500 focus:border-red-500 w-28">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select>
            </div>

            <!-- Apply -->
            <button id="applyBtn"
                    class="ml-auto inline-flex items-center gap-1 px-5 py-2.5
                        bg-red-600 hover:bg-red-500 text-white font-medium rounded-lg
                        shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
            Apply
            </button>
        </section>
        <!-- ╰────────────────────────────────────────────────────────────────────╯ -->

        <!-- ╭─ TABLE ────────────────────────────────────────────────────────────╮ -->
        <section class="bg-white shadow rounded-2xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600 sticky top-0 z-10">
            <tr>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Order ID</th>
                <th class="px-6 py-3 text-right">Amount</th>
                <th class="px-6 py-3 text-left">Razorpay ID</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-center">Actions</th>
            </tr>
            </thead>
            <tbody id="tableBody" class="divide-y divide-gray-100 bg-white"></tbody>
            </table>
        </section>
        <!-- ╰────────────────────────────────────────────────────────────────────╯ -->

        <footer class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-gray-700">
            <div id="resultCount">0 results</div>
            <nav id="pagination" class="flex items-center gap-2"></nav>
        </footer>
    </div>

    <!-- Row template -->
    <template id="rowTemplate">
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 font-medium text-gray-900" data-f="name"></td>
        <td class="px-6 py-4 text-gray-700 break-all"    data-f="email"></td>
        <td class="px-6 py-4"                            data-f="oid"></td>
        <td class="px-6 py-4 text-right"                 data-f="amt"></td>
        <td class="px-6 py-4 break-all"                  data-f="rzid"></td>
        <td class="px-6 py-4"                            data-f="date"></td>
        <td class="px-6 py-4"                            data-f="status"></td>
        <td class="px-6 py-4 text-center space-x-1">
        <button class="viewBtn   w-8 h-8 rounded-full bg-indigo-600 hover:bg-indigo-500 text-white inline-flex items-center justify-center" title="View"><i data-lucide="eye"></i></button>
        <button class="editBtn   w-8 h-8 rounded-full bg-blue-600   hover:bg-blue-500   text-white inline-flex items-center justify-center" title="Edit"><i data-lucide="pencil"></i></button>
        <button class="delBtn    w-8 h-8 rounded-full bg-red-600    hover:bg-red-500    text-white inline-flex items-center justify-center" title="Delete"><i data-lucide="trash-2"></i></button>
        </td>
    </tr>
    </template>
</div>

<!-- ╭─ JAVASCRIPT ─────────────────────────────────────────────────────────╮ -->
<script>
  lucide.createIcons();

  /* ------------------------------------------------------------------
     CONFIG & STATE
  ------------------------------------------------------------------ */
  const API_ORDERS = `<?php echo BASE_URL; ?>/admin/user_orders`;
  const API_USERS  = `<?php echo BASE_URL; ?>/users`;              // adjust if different

  let userId = null;        // selected user id
  let limit  = 10;
  let offset = 0;
  let total  = 0;

  /* ------------------------------------------------------------------
     HELPERS
  ------------------------------------------------------------------ */
  const rupee = new Intl.NumberFormat('en-IN', {
    style:'currency', currency:'INR', maximumFractionDigits:0
  });

  /* ------------------------------------------------------------------
     USER NAME AUTOCOMPLETE
  ------------------------------------------------------------------ */
  const suggestBox = document.getElementById('userSuggest');
  const userInput  = document.getElementById('userSearch');
  let suggestTimer;

  userInput.addEventListener('input', () => {
    const term = userInput.value.trim();
    if (suggestTimer) clearTimeout(suggestTimer);
    if (term.length < 2) { suggestBox.classList.add('hidden'); return; }

    suggestTimer = setTimeout(() => searchUsers(term), 300);
  });

  async function searchUsers(term) {
    try {
      const token = localStorage.getItem('authToken');
      const res   = await fetch(`${API_USERS}?search=${encodeURIComponent(term)}`, {
        headers:{Authorization:`Bearer ${token}`}
      });
      const json  = await res.json();
      if (!json.success) throw 0;
      const list  = Array.isArray(json.data) ? json.data : [];

      suggestBox.innerHTML = '';
      list.forEach(u => {
        const li = document.createElement('li');
        li.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
        li.textContent = `${u.name} (ID ${u.id})`;
        li.addEventListener('click', () => {
          userInput.value = u.name;
          userId = u.id;
          suggestBox.classList.add('hidden');
        });
        suggestBox.appendChild(li);
      });
      suggestBox.classList.toggle('hidden', list.length === 0);
    } catch { suggestBox.classList.add('hidden'); }
  }

  // hide suggestions on click outside
  document.addEventListener('click', e=>{
    if(!suggestBox.contains(e.target) && e.target!==userInput){
      suggestBox.classList.add('hidden');
    }
  });

  /* ------------------------------------------------------------------
     FETCH ORDERS
  ------------------------------------------------------------------ */
  async function fetchOrders() {
    const token = localStorage.getItem('authToken');
    const payload = { limit, offset };
    if (userId) payload.user_id = userId;

    try{
      const res  = await fetch(API_ORDERS,{
        method:'POST',
        headers:{'Content-Type':'application/json', Authorization:`Bearer ${token}`},
        body: JSON.stringify(payload)
      });
      const json = await res.json();
      if(!json.success) throw json.message;
      total = json.total_count || json.data.length;
      renderTable(json.data);
    }catch(err){
      console.error(err);
      total = 0;
      renderTable([]);
    }
    renderPagination();
    document.getElementById('resultCount').textContent = `${total} result${total!==1?'s':''}`;
  }

  /* ------------------------------------------------------------------
     RENDER TABLE
  ------------------------------------------------------------------ */
  function renderTable(rows){
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML='';
    const tmpl  = document.getElementById('rowTemplate');

    rows.forEach(item=>{
      const tr = tmpl.content.cloneNode(true);
      const u  = item.user   || {name:'—',email:'—'};
      const o  = item.orders || {};

      tr.querySelector('[data-f="name"]').textContent  = u.name;
      tr.querySelector('[data-f="email"]').textContent = u.email;
      tr.querySelector('[data-f="oid"]').textContent   = o.order_id ?? '—';
      tr.querySelector('[data-f="amt"]').textContent   = o.amount!=null ? rupee.format(o.amount) : '—';
      tr.querySelector('[data-f="rzid"]').textContent  = o.razorpay_order_id ?? '—';
      tr.querySelector('[data-f="date"]').textContent  = o.date ?? '—';
      tr.querySelector('[data-f="status"]').textContent= o.status ?? '—';

      // actions
      tr.querySelector('.viewBtn').onclick  = ()=>alert('VIEW order '+o.order_id);
      tr.querySelector('.editBtn').onclick  = ()=>alert('EDIT order '+o.order_id);
      tr.querySelector('.delBtn').onclick   = ()=>{
        if(confirm('Delete order '+o.order_id+'?')) alert('Call delete API here');
      };

      tbody.appendChild(tr);
    });
    lucide.createIcons();
  }

  /* ------------------------------------------------------------------
     PAGINATION
  ------------------------------------------------------------------ */
  function renderPagination(){
    const nav=document.getElementById('pagination');
    nav.innerHTML='';
    const totalPages=Math.max(1,Math.ceil(total/limit));
    const page=Math.floor(offset/limit)+1;

    const btn=(lab,p,dis=false)=>{
      const b=document.createElement('button');
      b.textContent=lab;b.dataset.p=p;b.disabled=dis;
      b.className=`px-3 py-1.5 rounded-md border transition ${
        p===page?'bg-red-600 text-white border-red-600':
                 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
      } ${dis?'opacity-50 cursor-not-allowed':''}`;
      return b;
    };
    nav.appendChild(btn('Prev',page-1,page===1));
    for(let i=1;i<=totalPages;i++) nav.appendChild(btn(i,i));
    nav.appendChild(btn('Next',page+1,page===totalPages));
  }

  // pagination click
  document.getElementById('pagination').addEventListener('click',e=>{
    if(e.target.tagName==='BUTTON' && !e.target.disabled){
      offset=(Number(e.target.dataset.p)-1)*limit;
      fetchOrders();
    }
  });

  // rows per page
  document.getElementById('rowsPerPage').addEventListener('change',()=>{
    limit = Number(document.getElementById('rowsPerPage').value);
    offset=0;
    fetchOrders();
  });

  // apply button
  document.getElementById('applyBtn').addEventListener('click', ()=>{
    offset=0;
    // if they changed the text but didn't pick a suggestion, reset userId
    if(userInput.value.trim().length<2 || !userInput.value.startsWith(userInput.value.trim())) userId=null;
    fetchOrders();
  });

  /* ------------------------------------------------------------------
     FIRST LOAD
  ------------------------------------------------------------------ */
  fetchOrders();
</script>