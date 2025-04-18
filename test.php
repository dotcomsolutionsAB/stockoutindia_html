<?php include("configs/config_static_data.php"); // defines BASE_URL ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Users & Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 text-sm leading-relaxed antialiased">
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
  <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Users with Products</h1>

  <!-- ╭─ FILTER BAR ──────────────────────────────────────────────────────╮ -->
  <section
    class="bg-white shadow rounded-2xl p-6 flex flex-wrap gap-4 items-end">

    <!-- User‑IDs (comma list) -->
    <div class="flex flex-col gap-1">
      <label for="userIds" class="font-medium text-gray-700">User IDs (comma‑separated)</label>
      <input id="userIds" type="text" placeholder="e.g. 1,6,5"
             class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-64
                    focus:ring-red-500 focus:border-red-500">
    </div>

    <!-- Rows‑per‑page -->
    <div class="flex flex-col gap-1">
      <label for="rowsPerPage" class="font-medium text-gray-700">Show</label>
      <select id="rowsPerPage"
              class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-24
                     focus:ring-red-500 focus:border-red-500">
        <option value="10" selected>10</option>
        <option value="20">20</option>
        <option value="40">40</option>
        <option value="50">50</option>
      </select>
    </div>

  </section>
  <!-- ╰────────────────────────────────────────────────────────────────────╯ -->

  <!-- ╭─ TABLE ────────────────────────────────────────────────────────────╮ -->
  <section class="bg-white shadow rounded-2xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600 sticky top-0 z-10">
      <tr>
        <th class="px-6 py-3 text-left w-1/5">Name</th>
        <th class="px-6 py-3 text-left w-1/4">Email</th>
        <th class="px-6 py-3 text-left">Products</th>
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
    <td class="px-6 py-4 break-all text-gray-700"    data-f="email"></td>
    <td class="px-6 py-4"                            data-f="products"></td>
  </tr>
</template>

<!-- ╭─ JAVASCRIPT ─────────────────────────────────────────────────────────╮ -->
<script>
  lucide.createIcons();

  /* ------------------------------------------------------------------
     CONFIG
  ------------------------------------------------------------------ */
  const BASE_URL = '<?php echo BASE_URL; ?>';
  const API_URL  = `${BASE_URL}/admin/users_with_products`;

  /* ------------------------------------------------------------------
     STATE
  ------------------------------------------------------------------ */
  let limit  = 10;
  let offset = 0;
  let total  = 0;
  let currentIds = '';

  /* ------------------------------------------------------------------
     HELPERS
  ------------------------------------------------------------------ */
  const rupee = new Intl.NumberFormat('en-IN', {
    style:'currency', currency:'INR', maximumFractionDigits:0
  });
  const debounce = (fn,ms)=>{let t;return(...a)=>{clearTimeout(t);t=setTimeout(()=>fn(...a),ms)}};

  /* ------------------------------------------------------------------
     FETCH & RENDER
  ------------------------------------------------------------------ */
  async function fetchUsersProducts(){
    const token = localStorage.getItem('authToken');
    const body  = { limit, offset };
    if(currentIds) body.user_ids = currentIds;

    try{
      const res  = await fetch(API_URL,{
        method :'POST',
        headers:{'Content-Type':'application/json', Authorization:`Bearer ${token}`},
        body   : JSON.stringify(body)
      });
      const json = await res.json();
      if(!json.success) throw 0;

      total = json.total_count || json.data.length;
      renderTable(json.data);
    }catch(e){
      total = 0;
      renderTable([]);
    }
    renderPagination();
    document.getElementById('resultCount').textContent = `${total} result${total!==1?'s':''}`;
  }

  /* ---------------- TABLE ---------------- */
  function renderTable(rows){
    const tbody=document.getElementById('tableBody');
    tbody.innerHTML='';
    const tmpl=document.getElementById('rowTemplate');

    rows.forEach(u=>{
      const tr=tmpl.content.cloneNode(true);
      tr.querySelector('[data-f="name"]').textContent  = u.name ?? '—';
      tr.querySelector('[data-f="email"]').textContent = u.email ?? '—';

      const cell = tr.querySelector('[data-f="products"]');
      if(Array.isArray(u.products) && u.products.length){
        const list = document.createElement('ul');
        list.className='space-y-1';
        u.products.forEach(p=>{
          const li=document.createElement('li');
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
      }else{
        cell.innerHTML='<span class="text-gray-400">No products</span>';
      }
      tbody.appendChild(tr);
    });
  }

  /* ---------------- PAGINATION ---------------- */
  function renderPagination(){
    const nav=document.getElementById('pagination');
    nav.innerHTML='';
    const page=Math.floor(offset/limit)+1;
    const pages=Math.max(1,Math.ceil(total/limit));

    const makeBtn=(lab,p,dis=false)=>{
      const b=document.createElement('button');
      b.textContent=lab; b.dataset.p=p; b.disabled=dis;
      b.className=`px-3 py-1.5 rounded-md border transition ${
        p===page?'bg-red-600 text-white border-red-600':
                 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'
      } ${dis?'opacity-50 cursor-not-allowed':''}`;
      return b;
    };

    nav.appendChild(makeBtn('Prev',page-1,page===1));
    for(let i=1;i<=pages;i++) nav.appendChild(makeBtn(i,i));
    nav.appendChild(makeBtn('Next',page+1,page===pages));
  }
  document.getElementById('pagination')
          .addEventListener('click',e=>{
            if(e.target.tagName==='BUTTON'&&!e.target.disabled){
              offset=(Number(e.target.dataset.p)-1)*limit;
              fetchUsersProducts();
            }
          });

  /* ---------------- EVENTS ---------------- */
  // rows per page
  document.getElementById('rowsPerPage')
          .addEventListener('change',()=>{
            limit = Number(rowsPerPage.value);
            offset=0;
            fetchUsersProducts();
          });

  // user‑ids input
  document.getElementById('userIds')
          .addEventListener('input',debounce(e=>{
            currentIds = e.target.value.replace(/\s+/g,''); // strip spaces
            offset=0;
            fetchUsersProducts();
          },300));

  /* ------------------------------------------------------------------
     FIRST LOAD
  ------------------------------------------------------------------ */
  fetchUsersProducts();
</script>
</body>
</html>
