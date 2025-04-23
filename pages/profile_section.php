<!-- ╔════════════ Account Information ════════════╗ -->
<div class="acc-user-info-box max-w-3xl mx-auto p-6 border rounded-lg shadow-sm bg-white">
  <h2 class="text-xl font-semibold mb-6">Account Information</h2>

  <!-- ── ❶ Read-only user data ── -->
  <div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="acc-user-group">
      <label for="name" class="block mb-1 font-medium text-gray-700">Name</label>
      <input id="name" class="acc-user-input w-full p-2 rounded border bg-gray-100" readonly>
    </div>
    <div class="acc-user-group">
      <label for="username" class="block mb-1 font-medium text-gray-700">Username</label>
      <input id="username" class="acc-user-input w-full p-2 rounded border bg-gray-100" readonly>
    </div>
    <div class="acc-user-group">
      <label for="role" class="block mb-1 font-medium text-gray-700">Role</label>
      <input id="role" class="acc-user-input w-full p-2 rounded border bg-gray-100" readonly>
    </div>
  </div>

  <!-- hidden id (optional use later) -->
  <input type="hidden" id="id">

  <!-- ── ❷ Password change ── -->
  <div class="grid md:grid-cols-3 gap-4 mb-8">
    <!-- New Password -->
    <div class="acc-user-group relative">
      <label for="newPassword" class="block mb-1 font-medium text-gray-700">New Password</label>
      <input type="password" id="newPassword" minlength="8"
             class="acc-user-input w-full p-2 pr-12 rounded border" placeholder="Min 8 chars">
      <button type="button" class="pwd-toggle" data-target="newPassword" title="Show / Hide">
        <i data-lucide="eye"></i>
      </button>
    </div>

    <!-- Confirm Password -->
    <div class="acc-user-group relative">
      <label for="confirmPassword" class="block mb-1 font-medium text-gray-700">Confirm Password</label>
      <input type="password" id="confirmPassword" minlength="8"
             class="acc-user-input w-full p-2 pr-12 rounded border" placeholder="Repeat password">
      <button type="button" class="pwd-toggle" data-target="confirmPassword" title="Show / Hide">
        <i data-lucide="eye"></i>
      </button>
    </div>

    <!-- spacer (keeps grid tidy) -->
    <div></div>
  </div>

  <!-- Update button -->
  <button class="acc-user-btn bg-red-600 text-white font-semibold px-6 py-3 rounded hover:bg-red-700"
          onclick="updatePassword()">
    Update Password
  </button>
</div>
<!-- ╚══════════════════════════════════════════════╝ -->

<!-- ─────────────── Styles ─────────────── -->
<style>
.acc-user-group { position: relative; }
.pwd-toggle{
  position:absolute; right:10px; top:50%; transform:translateY(-50%);
  background:none; border:none; cursor:pointer; line-height:0; color:#6b7280;
}
.pwd-toggle:hover { color:#111827; }
</style>

<!-- ─────────────── Scripts ─────────────── -->
<script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* ---------- Prefill read-only data ---------- */
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('name').value     = localStorage.getItem('name')     || '';
  document.getElementById('username').value = localStorage.getItem('username') || '';
  document.getElementById('role').value     = localStorage.getItem('role')     || '';
  document.getElementById('id').value       = localStorage.getItem('user_id')  || '';

  lucide.createIcons();                     // draw eye icons
});

/* ---------- Eye toggle (delegated) ---------- */
document.addEventListener('click', e => {
  const btn = e.target.closest('.pwd-toggle');
  if (!btn) return;

  const targetId = btn.dataset.target;
  const input    = document.getElementById(targetId);
  if (!input) return;

  const nowShown = input.type === 'password';
  input.type     = nowShown ? 'text' : 'password';

  // swap icon
  btn.innerHTML = '';
  const newIcon = nowShown ? 'eye-off' : 'eye';
  btn.appendChild(lucide.createElement(newIcon));
});

/* ---------- Live validation (colour feedback) ---------- */
['newPassword','confirmPassword'].forEach(id =>
  document.getElementById(id).addEventListener('input', validatePwds)
);

function validatePwds(){
  const np = document.getElementById('newPassword');
  const cp = document.getElementById('confirmPassword');

  const okLen  = np.value.length >= 8 && cp.value.length >= 8;
  const match  = np.value === cp.value && okLen;

  const green  = '#16a34a', orange = '#f97316', gray = '#d1d5db';

  np.style.borderColor = (np.value && np.value.length < 8) ? orange : gray;
  cp.style.borderColor = (cp.value ? (match ? green : orange) : gray);

  return match;
}

/* ---------- Update password only ---------- */
function updatePassword(){
  if (!validatePwds()){
    Swal.fire('Oops', 'Passwords must be at least 8 characters and match.', 'warning');
    return;
  }

  const userId   = localStorage.getItem('user_id');
  const token    = localStorage.getItem('authToken');
  const password = document.getElementById('newPassword').value;

  if (!token || !userId){
    Swal.fire('Error', 'Not logged in.', 'error');
    return;
  }

  Swal.showLoading();

  fetch(`<?php echo BASE_URL; ?>/user/${userId}`, {
    method :'POST',
    headers:{
      'Content-Type':'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify({ password })
  })
  .then(r => r.json())
  .then(res => {
    if (res.success){
      Swal.fire('Success', 'Password updated successfully!', 'success');
      document.getElementById('newPassword').value = '';
      document.getElementById('confirmPassword').value = '';
      validatePwds();
    } else {
      throw new Error(res.message || 'Update failed');
    }
  })
  .catch(err => {
    console.error(err);
    Swal.fire('Error', err.message || 'Server error', 'error');
  });
}
</script>
