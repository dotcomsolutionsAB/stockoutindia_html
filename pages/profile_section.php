<!-- ╔════════════ Account Information ════════════╗ -->
<div class="acc-user-info-box max-w-3xl mx-auto p-6 border rounded-lg shadow-sm bg-white">
  <h2 class="text-xl font-semibold mb-6">Account Information</h2>

  <!-- ❶ Read-only fields -->
  <div class="grid md:grid-cols-3 gap-4 mb-6">
    <div>
      <label class="block mb-1 font-medium text-gray-700">Name</label>
      <input id="name" class="w-full p-2 rounded border bg-gray-100" readonly>
    </div>
    <div>
      <label class="block mb-1 font-medium text-gray-700">Username</label>
      <input id="username" class="w-full p-2 rounded border bg-gray-100" readonly>
    </div>
    <div>
      <label class="block mb-1 font-medium text-gray-700">Role</label>
      <input id="role" class="w-full p-2 rounded border bg-gray-100" readonly>
    </div>
  </div>

  <input type="hidden" id="id"><!-- (kept for future use) -->

  <!-- ❷ Password change -->
  <div class="grid md:grid-cols-3 gap-4 mb-8">
    <!-- New pwd -->
    <div class="relative">
      <label class="block mb-1 font-medium text-gray-700">New Password</label>
      <input type="password" id="newPassword" minlength="8"
             class="w-full p-2 pr-12 rounded border" placeholder="Min 8 chars">
      <button type="button" class="pwd-toggle" data-target="newPassword" title="Show / Hide">
        <i data-lucide="eye"></i>
      </button>
    </div>

    <!-- Confirm pwd -->
    <div class="relative">
      <label class="block mb-1 font-medium text-gray-700">Confirm Password</label>
      <input type="password" id="confirmPassword" minlength="8"
             class="w-full p-2 pr-12 rounded border" placeholder="Repeat password">
      <button type="button" class="pwd-toggle" data-target="confirmPassword" title="Show / Hide">
        <i data-lucide="eye"></i>
      </button>
    </div>

    <!-- spacer -->
    <div></div>
  </div>

  <button class="bg-red-600 text-white font-semibold px-6 py-3 rounded hover:bg-red-700"
          onclick="updatePassword()">
    Update Password
  </button>
</div>
<!-- ╚══════════════════════════════════════════════╝ -->

<style>
.pwd-toggle{
  position:absolute; right:10px; top:50%; transform:translateY(-50%);
  background:none;border:none;cursor:pointer;line-height:0;color:#6b7280;
}
.pwd-toggle:hover{color:#111827}
</style>

<script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const BASE_URL = '<?php echo BASE_URL; ?>'; // make sure this is set

/* ─── Prefill read-only data ─── */
document.addEventListener('DOMContentLoaded', () => {
  ['name','username','role','user_id'].forEach(k=>{
    const el = document.getElementById(k==='user_id' ? 'id' : k);
    if (el) el.value = localStorage.getItem(k) || '';
  });
  lucide.createIcons();
});

/* ─── Eye toggle (swap icon & type) ─── */
document.addEventListener('click', e=>{
  const btn = e.target.closest('.pwd-toggle');
  if(!btn) return;

  const input = document.getElementById(btn.dataset.target);
  if(!input) return;

  const show = input.type === 'password';
  input.type = show ? 'text' : 'password';

  // change icon
  const ico = btn.querySelector('i');
  ico.setAttribute('data-lucide', show ? 'eye-off' : 'eye');
  lucide.createIcons();               // redraw just swapped icon
});

/* ─── Live validation colours ─── */
['newPassword','confirmPassword'].forEach(id=>{
  document.getElementById(id).addEventListener('input', validatePwds);
});
function validatePwds(){
  const np=document.getElementById('newPassword');
  const cp=document.getElementById('confirmPassword');
  const longEnough = np.value.length>=8 && cp.value.length>=8;
  const match = np.value===cp.value && longEnough;

  const ok='#16a34a', warn='#f97316', neutral='#d1d5db';
  np.style.borderColor = (np.value && np.value.length<8) ? warn : neutral;
  cp.style.borderColor = cp.value ? (match?ok:warn) : neutral;
  return match;
}

/* ─── Update password ─── */
function updatePassword(){
  if(!validatePwds()){
    Swal.fire('Oops','Passwords must be at least 8 characters and match.','warning');
    return;
  }
  const uid   = localStorage.getItem('user_id');
  const token = localStorage.getItem('authToken');
  if(!uid||!token){
    Swal.fire('Error','Not logged in.','error');return;
  }
  Swal.showLoading();
  fetch(`${BASE_URL}/user/${uid}`,{
    method:'POST',
    headers:{
      'Content-Type':'application/json',
      'Authorization':`Bearer ${token}`
    },
    body:JSON.stringify({ password:document.getElementById('newPassword').value })
  })
  .then(r=>r.json())
  .then(j=>{
    if(j.success){
      Swal.fire('Success','Password updated!','success');
      document.getElementById('newPassword').value='';
      document.getElementById('confirmPassword').value='';
      validatePwds();
    }else{throw new Error(j.message||'Update failed')}
  })
  .catch(err=>{
    console.error(err);
    Swal.fire('Error',err.message||'Server error','error');
  });
}
</script>
