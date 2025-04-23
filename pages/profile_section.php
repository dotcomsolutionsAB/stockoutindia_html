<!-- ═══════════ Account Information ═══════════ -->
<div class="acc-user-info-box">
  <h2 class="acc-user-title">Account Information</h2>

  <!-- ─── 1st-row (read-only user data) ─── -->
  <div class="acc-user-row">
    <div class="acc-user-group">
      <label for="name">Name</label>
      <input type="text" id="name" class="acc-user-input bg-gray-100" readonly />
    </div>
    <div class="acc-user-group">
      <label for="username">Username</label>
      <input type="text" id="username" class="acc-user-input bg-gray-100" readonly />
    </div>
    <div class="acc-user-group">
      <label for="role">Role</label>
      <input type="text" id="role" class="acc-user-input bg-gray-100" readonly />
    </div>
  </div>

  <!-- hidden id (in case you need it later) -->
  <input type="hidden" id="id" />

  <!-- ─── 2nd-row (password change) ─── -->
  <div class="acc-user-row">
    <!-- New password -->
    <div class="acc-user-group relative">
      <label for="newPassword">New Password</label>
      <input type="text" id="newPassword" class="acc-user-input pr-10" minlength="8" />
      <button type="button" onclick="togglePwd('newPassword')" class="pwd-toggle">👁</button>
    </div>

    <!-- Confirm password -->
    <div class="acc-user-group relative">
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" class="acc-user-input pr-10" minlength="8" />
      <button type="button" onclick="togglePwd('confirmPassword')" class="pwd-toggle">👁</button>
    </div>

    <!-- empty cell to balance grid -->
    <div class="acc-user-group"></div>
  </div>

  <!-- Update button -->
  <button class="acc-user-btn" onclick="updatePassword()">Update Password</button>
</div>

<style>
  /* tiny helper for eye button */
  .pwd-toggle{
    position:absolute; right:8px; top:34px;
    background:none; border:none; cursor:pointer; font-size:1rem; line-height:1;
    color:#6b7280;
  }
</style>


<script>
  /* ─────────── Prefill read-only fields ─────────── */
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('name').value     = localStorage.getItem('name')     || '';
      document.getElementById('username').value = localStorage.getItem('username') || '';
      document.getElementById('role').value     = localStorage.getItem('role')     || '';
    });

  /* ─────────── Show / hide password ─────────── */
  function togglePwd(id){
    const inp = document.getElementById(id);
    inp.type  = inp.type === 'password' ? 'text' : 'password';
  }

  /* ─────────── Live validation colours ─────────── */
  ['newPassword','confirmPassword'].forEach(id=>{
    document.getElementById(id).addEventListener('input', validatePwds);
  });
  function validatePwds(){
    const np  = document.getElementById('newPassword');
    const cp  = document.getElementById('confirmPassword');

    // both ≥8 chars?
    const longEnough = np.value.length>=8 && cp.value.length>=8;

    // match status
    const match = np.value === cp.value && longEnough;

    const okCol   = '#16a34a';   // green-500
    const warnCol = '#f97316';   // orange-500
    const neutral = '#d1d5db';   // gray-300

    np.style.borderColor = neutral;
    cp.style.borderColor = neutral;
    if (np.value || cp.value){
      np.style.borderColor = longEnough ? neutral : warnCol;
      cp.style.borderColor = match      ? okCol    : warnCol;
    }
    return match;
  }

  /* ─────────── Update password only ─────────── */
  function updatePassword(){
    if(!validatePwds()){
      Swal.fire('Oops','Passwords must be at least 8 characters and match.','warning');
      return;
    }

    const password = document.getElementById('newPassword').value;
    const userId = localStorage.getItem('user_id');   
    const token    = localStorage.getItem('authToken');
    if(!token){
      Swal.fire('Error','You are not logged in.','error');
      return;
    }

    Swal.showLoading();

    fetch(`<?php echo BASE_URL; ?>/user/${userId}`, {
      method :'POST',
      headers:{
        'Content-Type':'application/json',
        'Authorization':`Bearer ${token}`
      },
      body: JSON.stringify({ password })
    })
    .then(r => r.json())
    .then(res => {
      if(res.success){
        Swal.fire('Success','Password updated successfully!','success');
        // clear inputs for safety
        document.getElementById('newPassword').value     = '';
        document.getElementById('confirmPassword').value = '';
        validatePwds();
      }else{
        throw new Error(res.message || 'API error');
      }
    })
    .catch(err=>{
      console.error(err);
      Swal.fire('Error', err.message || 'Server error', 'error');
    });
  }
</script>
