<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stockout India – Register</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Feather icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
</head>
<body class="bg-cover bg-center bg-no-repeat"
      style="background-image:url('https://www.stockoutindia.com/assets/img/contact-bg.png')">

  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">

    <!-- ■ Left banner (hidden ≤ md) -->
    <div class="w-1/2 text-white px-10 hidden md:block">
      <div class="max-w-md">
        <img src="uploads/stockout_logo.png" alt="Logo" class="mb-4 w-28">
        <h1 class="text-4xl font-bold mb-4">Stockout India</h1>
        <p class="text-lg leading-relaxed">
          The easiest way to sell your dead stock. <br>
          Join thousands of interested buyers.
        </p>
      </div>
    </div>

    <!-- ■ Register card -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-8 shadow-lg max-w-2xl mx-auto">

        <h2 class="text-xl font-bold text-red-700 mb-6">Sign up to Stockout India</h2>

        <!-- ───────────── REGISTER FORM ───────────── -->
        <form id="registerForm" class="space-y-6">

          <!-- GST toggle -->
          <label class="flex items-center gap-2 select-none text-sm">
            <input id="noGstChk" type="checkbox" class="accent-red-600 rounded">
            I&nbsp;don’t have a&nbsp;GSTIN
          </label>

          <!-- GSTIN field -->
          <div id="gstFieldGroup">
            <input id="gstin" type="text" placeholder="GSTIN"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
          </div>

          <!-- EXTRA details (full name …) -->
          <div id="extraGroup" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <input id="fullName"     type="text" placeholder="Full Name"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <input id="companyName"  type="text" placeholder="Company Name"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
            </div>

            <textarea id="address" placeholder="Complete Address" rows="3"
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

          <!-- BASIC fields (always visible) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <input id="phone"  type="text"  placeholder="Phone"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
            <input id="email"  type="email" placeholder="Email"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">

            <!-- pwd + eye -->
            <div class="relative">
              <input id="pass" type="password" placeholder="Password"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md pr-10">
              <i class="toggleEye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"
                 data-feather="eye"></i>
            </div>
            <div class="relative">
              <input id="cpass" type="password" placeholder="Confirm Password"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md pr-10">
              <i class="toggleEye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"
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
              <a href="#" class="text-red-600 font-medium">Terms & Conditions</a>
              and the
              <a href="#" class="text-red-600 font-medium">Privacy Policy</a>.
            </span>
          </label>

          <!-- Submit -->
          <button type="submit"
                  class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            Register
          </button>
        </form>

        <!-- Google -->
        <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mt-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google"
               class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600 mt-4">
          Already have an account?
          <a href="login.php" class="text-red-600 font-semibold">Sign in</a>
        </p>
      </div>
    </div>
  </div>

  <!-- ───────────── INTERACTIVITY ───────────── -->
  <script>
    feather.replace();                                // draw icons once

    /* 1. password eye toggles */
    document.querySelectorAll('.toggleEye').forEach(icon => {
      icon.addEventListener('click', () => {
        const input = icon.previousElementSibling;
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.setAttribute('data-feather', show ? 'eye-off' : 'eye');
        feather.replace(icon);                       // redraw just this icon
      });
    });

    /* 2. show / hide GST + extra group */
    const noGstChk = document.getElementById('noGstChk');
    const gstGrp   = document.getElementById('gstFieldGroup');
    const extraGrp = document.getElementById('extraGroup');
    const syncVis  = () => {
      const hideGst = noGstChk.checked;
      gstGrp.classList.toggle('hidden', hideGst);
      extraGrp.classList.toggle('hidden', !hideGst);
    };
    noGstChk.onchange = syncVis; syncVis();

    /* 3. Fetch State / City / Industry / Sub-industry */
    const stateSel  = document.getElementById('stateSelect');
    const citySel   = document.getElementById('citySelect');
    const indSel    = document.getElementById('industrySelect');
    const subSel    = document.getElementById('subIndustrySelect');

    let states=[], cities=[], industries=[], subIndustries=[];

    const token = localStorage.getItem('authToken') ?? '';  // if needed

    async function fetchJSON(url){
      const r = await fetch(url,{headers:{Authorization:`Bearer ${token}`}});
      return (await r.json()).data;
    }
    (async () => {
      [states,cities,industries,subIndustries] = await Promise.all([
        fetchJSON('/states'),
        fetchJSON('/cities'),
        fetchJSON('/industry'),
        fetchJSON('/sub_industry')
      ]);

      // states
      states.forEach(s=>{
        stateSel.insertAdjacentHTML('beforeend',
          `<option value="${s.name}">${s.name}</option>`);
      });

      // industries
      industries.forEach(i=>{
        indSel.insertAdjacentHTML('beforeend',
          `<option value="${i.id}">${i.name}</option>`);
      });
    })();

    // populate cities when state chosen
    stateSel.onchange = () =>{
      citySel.innerHTML = '<option value="">Select City</option>';
      if(!stateSel.value){ citySel.disabled=true; return; }
      cities.filter(c=>c.state_name===stateSel.value)
            .forEach(c=>{
              citySel.insertAdjacentHTML('beforeend',
                `<option value="${c.name}">${c.name}</option>`);
            });
      citySel.disabled=false;
    };

    // populate sub-industries when industry chosen
    indSel.onchange = ()=>{
      subSel.innerHTML = '<option value="">Select Sub-industry</option>';
      if(!indSel.value){ subSel.disabled=true; return; }
      subIndustries.filter(s=>String(s.industry_id??s.id).startsWith(indSel.value))
                   .forEach(s=>{
                      subSel.insertAdjacentHTML('beforeend',
                        `<option value="${s.id}">${s.name}</option>`);
                   });
      subSel.disabled=false;
    };

    /* 4. demo submit → alert payload */
    document.getElementById('registerForm').addEventListener('submit',e=>{
      e.preventDefault();

      const data = {
        gstin          : document.getElementById('gstin').value || null,
        full_name      : document.getElementById('fullName').value || null,
        company_name   : document.getElementById('companyName').value || null,
        address        : document.getElementById('address').value || null,
        pincode        : document.getElementById('pincode').value || null,
        state          : stateSel.value || null,
        city           : citySel.value || null,
        phone          : document.getElementById('phone').value,
        email          : document.getElementById('email').value,
        password       : document.getElementById('pass').value,
        industry_id    : indSel.value || null,
        sub_industry_id: subSel.value || null
      };
      alert(JSON.stringify(data, null, 2));   // show in pretty JSON
    });
  </script>
</body>
</html>
