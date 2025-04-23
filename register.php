<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Stockout India – Register</title>

  <!-- Tailwind & Feather -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
</head>
<?php include("configs/config_static_data.php"); ?>
<body class="bg-cover bg-center bg-no-repeat"
      style="background-image:url('https://www.stockoutindia.com/assets/img/contact-bg.png')">

  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">

    <!-- ◂── Banner (hidden ≤ md) -->
    <div class="w-1/2 text-white px-10 hidden md:block">
      <div class="max-w-md">
        <img src="uploads/stockout_logo.png" class="w-28 mb-4" alt="logo">
        <h1 class="text-4xl font-bold mb-4">Stockout India</h1>
        <p class="text-lg leading-relaxed">
          The easiest way to sell your dead stock.<br>
          Join thousands of interested buyers.
        </p>
      </div>
    </div>

    <!-- ▸── Register card -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-8 shadow-lg max-w-2xl mx-auto">

        <h2 class="text-xl font-bold text-red-700 mb-6">
          Sign up to Stockout India
        </h2>

        <!-- ╭─ FORM ───────────────────────────────────────────────╮ -->
        <form id="registerForm" class="space-y-6">

          <!-- GSTIN group -->
          <div id="gstFieldGroup">
            <input id="gstin" type="text" placeholder="GSTIN"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
            <p id="gstMsg" class="text-sm mt-1 h-5"></p>
          </div>
          <!-- GSTIN toggle -->
          <label class="flex items-center gap-2 text-sm select-none">
            <input id="noGstChk" type="checkbox" class="accent-red-600 rounded">
            I&nbsp;don’t have a&nbsp;GSTIN
          </label>

          <!-- Extra details (only when no GSTIN) -->
          <div id="extraGroup" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <input id="fullName"    type="text" placeholder="Full Name"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <input id="companyName" type="text" placeholder="Company Name"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
            </div>

            <textarea id="address" rows="3" placeholder="Complete Address"
                      class="w-full border border-gray-400 px-3 py-2 rounded-md resize-none mt-4"></textarea>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
              <input id="pincode" type="text" placeholder="Pincode"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <select id="stateSelect"
                      class="w-full border border-gray-400 px-3 py-2 rounded-md">
                <option value="">Select State</option>
              </select>
              <select id="citySelect" disabled
                      class="w-full border border-gray-400 px-3 py-2 rounded-md">
                <option value="">Select City</option>
              </select>
            </div>
          </div>

          <!-- Always-visible block -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <input id="phone" type="text" placeholder="Phone"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
            <input id="email" type="email" placeholder="Email"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">

            <!-- pwd + eye -->
            <div class="relative">
              <input id="pass" type="password" placeholder="Password"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md pr-10">
              <i class="eye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"
                 data-feather="eye"></i>
            </div>
            <div class="relative">
              <input id="cpass" type="password" placeholder="Confirm Password"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md pr-10">
              <i class="eye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"
                 data-feather="eye"></i>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <select id="industrySelect"
                    class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <option value="">Select Industry</option>
            </select>
            <select id="subIndustrySelect" disabled
                    class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <option value="">Select Sub-industry</option>
            </select>
          </div>

          <!-- Terms -->
          <label class="flex items-start gap-2 text-sm mt-2 select-none">
            <input type="checkbox" required class="accent-red-600 rounded mt-1">
            <span>
              By registering you confirm that you accept the
              <a href="#" class="text-red-600 font-medium">Terms &amp; Conditions</a>
              and the
              <a href="#" class="text-red-600 font-medium">Privacy Policy</a>.
            </span>
          </label>

          <button type="submit"
                  class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            Register
          </button>
        </form>
        <!-- ╰────────────────────────────────────────────────────────╯ -->

        <!-- Google sign-up -->
        <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mt-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
               class="w-5 h-5 mr-2" alt="Google">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600 mt-4">
          Already have an account?
          <a href="login.php" class="text-red-600 font-semibold">Sign in</a>
        </p>
      </div>
    </div>
  </div>

<!-- ────────────────────────────────────────── JS ─────────────────── -->
<!-- <script>
  const BASE = `<?php echo BASE_URL; ?>`;
  const token = localStorage.getItem('authToken') ?? '';

  feather.replace();

  /* eye toggles */
  document.querySelectorAll('.eye').forEach(icon=>{
    icon.onclick=()=>{
      const inp=icon.previousElementSibling;
      const open=inp.type==='password';
      inp.type=open?'text':'password';
      icon.setAttribute('data-feather',open?'eye-off':'eye');
      feather.replace(icon);
    };
  });

  /* GST toggle */
  const noGstChk=document.getElementById('noGstChk');
  const gstGrp=document.getElementById('gstFieldGroup');
  const extraGrp=document.getElementById('extraGroup');
  const syncVis=()=>{const hide=noGstChk.checked;
    gstGrp.classList.toggle('hidden',hide);
    extraGrp.classList.toggle('hidden',!hide);};
  noGstChk.onchange=syncVis; syncVis();

  /* dropdown refs */
  const stateSel=document.getElementById('stateSelect');
  const citySel=document.getElementById('citySelect');
  const indSel=document.getElementById('industrySelect');
  const subSel=document.getElementById('subIndustrySelect');

  let states=[],cities=[],industries=[],subsCache=[];

  const fetchData=path=>fetch(`${BASE}${path}`,{
     headers:{Authorization:`Bearer ${token}`} }).then(r=>r.json()).then(j=>j.data);

  (async()=>{
    [states,cities,industries]=await Promise.all([
      fetchData('/states'),fetchData('/cities'),fetchData('/industry')
    ]);
    states.forEach(s=>stateSel.insertAdjacentHTML('beforeend',
      `<option value="${s.name}">${s.name}</option>`));
    industries.forEach(i=>indSel.insertAdjacentHTML('beforeend',
      `<option value="${i.id}">${i.name}</option>`));
  })();

  stateSel.onchange=()=>{
    citySel.innerHTML='<option value="">Select City</option>';
    if(!stateSel.value){citySel.disabled=true;return;}
    cities.filter(c=>c.state_name===stateSel.value)
          .forEach(c=>citySel.insertAdjacentHTML('beforeend',
            `<option value="${c.name}">${c.name}</option>`));
    citySel.disabled=false;
  };

  indSel.onchange=async()=>{
    subSel.innerHTML='<option value="">Select Sub-industry</option>';
    if(!indSel.value){subSel.disabled=true;return;}
    if(!subsCache.length) subsCache = await fetchData('/sub_industry');
    subsCache.filter(s=>String(s.industry_id??s.id).startsWith(indSel.value))
             .forEach(s=>subSel.insertAdjacentHTML('beforeend',
               `<option value="${s.id}">${s.name}</option>`));
    subSel.disabled=false;
  };

  /* GST validation & auto-fill */
  const gstInput=document.getElementById('gstin');
  const gstMsg=document.getElementById('gstMsg');

  gstInput.addEventListener('blur',async()=>{
    const v=gstInput.value.trim();
    gstMsg.textContent=''; gstMsg.className='text-sm mt-1 h-5';
    if(!v||noGstChk.checked) return;

    gstMsg.textContent='Validating…'; gstMsg.classList.add('text-gray-500');
    const fd=new FormData(); fd.append('gstin',v);

    try{
      const res=await fetch(`${BASE}/gst_details`,{
        method:'POST', headers:{Authorization:`Bearer ${token}`}, body:fd});
      const j=await res.json();

      if(j.success){
        const d=j.data;
        // auto-fill target fields (only if empty)
        if(!document.getElementById('companyName').value)
          document.getElementById('companyName').value=d.company_name||'';
        if(!document.getElementById('fullName').value)
          document.getElementById('fullName').value=d.name||'';
        if(!document.getElementById('address').value)
          document.getElementById('address').value=d.address||'';
        if(!document.getElementById('pincode').value)
          document.getElementById('pincode').value=d.pincode||'';

        if(d.state){stateSel.value=d.state;stateSel.onchange();}
        setTimeout(()=>{if(d.city) citySel.value=d.city;},60);

        gstMsg.textContent='GSTIN verified & auto-filled';
        gstMsg.className='text-sm mt-1 h-5 text-green-600';
      }else throw new Error(j.message||'Invalid GSTIN');
    }catch(err){
      gstMsg.textContent=err.message;
      gstMsg.className='text-sm mt-1 h-5 text-red-600';
    }
  });

  /* submit demo */
  document.getElementById('registerForm').onsubmit=e=>{
    e.preventDefault();
    const obj={
      gstin:gstInput.value||null,
      full_name:document.getElementById('fullName').value||null,
      company_name:document.getElementById('companyName').value||null,
      address:document.getElementById('address').value||null,
      pincode:document.getElementById('pincode').value||null,
      state:stateSel.value||null,
      city:citySel.value||null,
      phone:document.getElementById('phone').value,
      email:document.getElementById('email').value,
      password:document.getElementById('pass').value,
      industry_id:indSel.value||null,
      sub_industry_id:subSel.value||null
    };
    alert(JSON.stringify(obj,null,2));
  };
</script> -->
<script>
/* ─── Constants ───────────────────────────────────────────── */
const BASE  = `<?php echo BASE_URL; ?>`;
const token = localStorage.getItem('authToken') ?? '';

/* ─── Feather / eye toggles ───────────────────────────────── */
feather.replace();
document.querySelectorAll('.eye').forEach(icon=>{
  icon.onclick = ()=>{
    const inp = icon.previousElementSibling;
    const open = inp.type === 'password';
    inp.type = open ? 'text' : 'password';
    icon.setAttribute('data-feather', open ? 'eye-off' : 'eye');
    feather.replace(icon);
  };
});

/* ─── GST toggle (no GSTIN) ──────────────────────────────── */
const noGstChk = document.getElementById('noGstChk');
const gstGrp   = document.getElementById('gstFieldGroup');
const extraGrp = document.getElementById('extraGroup');
const syncVis  = () =>{
  const hide = noGstChk.checked;
  gstGrp.classList.toggle('hidden', hide);
  extraGrp.classList.toggle('hidden', !hide);
};
noGstChk.onchange = syncVis; syncVis();

/* ─── Load states, cities, industries ─────────────────────── */
const stateSel=document.getElementById('stateSelect');
const citySel =document.getElementById('citySelect');
const indSel  =document.getElementById('industrySelect');
const subSel  =document.getElementById('subIndustrySelect');

let states=[],cities=[],industries=[],subsCache=[];
const fetchData = path => fetch(`${BASE}${path}`,
  {headers:{Authorization:`Bearer ${token}`}})
  .then(r=>r.json()).then(j=>j.data);

(async()=>{
  [states,cities,industries] = await Promise.all([
    fetchData('/states'), fetchData('/cities'), fetchData('/industry')
  ]);
  states.forEach(s=>stateSel.insertAdjacentHTML('beforeend',
    `<option value="${s.id}" data-name="${s.name}">${s.name}</option>`));
  industries.forEach(i=>indSel.insertAdjacentHTML('beforeend',
    `<option value="${i.id}">${i.name}</option>`));
})();

stateSel.onchange = ()=>{
  const stName = stateSel.selectedOptions[0]?.dataset.name || '';
  citySel.innerHTML = '<option value="">Select City</option>';
  if(!stName){citySel.disabled=true;return;}
  cities.filter(c=>c.state_name===stName)
        .forEach(c=>citySel.insertAdjacentHTML('beforeend',
          `<option value="${c.name}">${c.name}</option>`));
  citySel.disabled=false;
};

indSel.onchange = async()=>{
  subSel.innerHTML='<option value="">Select Sub-industry</option>';
  if(!indSel.value){subSel.disabled=true;return;}
  if(!subsCache.length) subsCache = await fetchData('/sub_industry');
  subsCache.filter(s=>String(s.industry_id??s.id).startsWith(indSel.value))
           .forEach(s=>subSel.insertAdjacentHTML('beforeend',
             `<option value="${s.id}">${s.name}</option>`));
  subSel.disabled=false;
};

/* ─── GST validation & auto-fill ─────────────────────────── */
const gstInput=document.getElementById('gstin');
const gstMsg  =document.getElementById('gstMsg');
gstInput.addEventListener('blur', async()=>{
  const v=gstInput.value.trim();
  gstMsg.textContent=''; gstMsg.className='text-sm mt-1 h-5';
  if(!v||noGstChk.checked) return;

  gstMsg.textContent='Validating…'; gstMsg.classList.add('text-gray-500');
  const fd=new FormData(); fd.append('gstin',v);

  try{
    const j=await fetch(`${BASE}/gst_details`,
             {method:'POST',headers:{Authorization:`Bearer ${token}`},body:fd})
             .then(r=>r.json());
    if(j.success){
      const d=j.data;
      if(!document.getElementById('companyName').value)
        document.getElementById('companyName').value=d.company_name||'';
      if(!document.getElementById('fullName').value)
        document.getElementById('fullName').value=d.name||'';
      if(!document.getElementById('address').value)
        document.getElementById('address').value=d.address||'';
      if(!document.getElementById('pincode').value)
        document.getElementById('pincode').value=d.pincode||'';

      if(d.state){
        const st=states.find(s=>s.name.toLowerCase()===d.state.toLowerCase());
        if(st){stateSel.value=st.id; stateSel.onchange();}
      }
      setTimeout(()=>{ if(d.city) citySel.value=d.city; },60);

      gstMsg.textContent='GSTIN verified & auto-filled';
      gstMsg.className='text-sm mt-1 h-5 text-green-600';
    }else throw new Error(j.message||'Invalid GSTIN');
  }catch(err){
    gstMsg.textContent=err.message;
    gstMsg.className='text-sm mt-1 h-5 text-red-600';
  }
});

/* ─── REGISTER API call ──────────────────────────────────── */
document.getElementById('registerForm').onsubmit = async e=>{
  e.preventDefault();

  const payload = {
    gstin        : gstInput.value.trim(),
    phone        : document.getElementById('phone').value.trim(),
    email        : document.getElementById('email').value.trim(),
    password     : document.getElementById('pass').value,
    google_id    : "",
    role         : "user",                       // ← default role
    industry     : indSel.value,
    sub_industry : subSel.value
  };

  /* Optional extras */
  const extras = {
    name         : 'fullName',
    company_name : 'companyName',
    address      : 'address',
    pincode      : 'pincode',
    city         : 'citySelect',
    state        : 'stateSelect'                 // already numeric id
  };
  Object.entries(extras).forEach(([k,id])=>{
    const val=document.getElementById(id).value;
    if(val) payload[k]=val;
  });

  try{
    const res = await fetch(`${BASE}/register`,{
      method :'POST',
      headers:{'Content-Type':'application/json'},
      body   : JSON.stringify(payload)
    });
    const json = await res.json();

    if(json.success){
      alert('Registration successful! Redirecting to login…');
      location.href = 'login.php';               // ← redirect
    }else{
      throw new Error(json.message||'Registration failed');
    }
  }catch(err){
    alert(`❌ ${err.message}`);
  }
};
</script>


</body>
</html>
