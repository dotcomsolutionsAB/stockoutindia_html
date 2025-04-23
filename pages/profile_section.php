<!-- ╔════════════ Account Information ════════════╗ -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Account Info</title>

  <!-- Tailwind CDN (v3) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

  <div class="acc-user-info-box max-w-3xl w-full mx-auto p-6 bg-white border rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-6">Account Information</h2>

    <!-- ❶ Read-only details -->
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
      <!-- New password -->
      <div class="relative">
        <label class="block mb-1 font-medium text-gray-700">New Password</label>
        <input type="password" id="newPassword" minlength="8"
               class="w-full p-2 pr-12 rounded border focus:ring-2 focus:ring-red-500"
               placeholder="Min 8 characters">
        <button type="button" class="pwd-toggle absolute inset-y-0 right-0 flex items-center px-3"
                data-target="newPassword" title="Show / Hide">
          <i data-lucide="eye" class="w-5 h-5 text-gray-500"></i>
        </button>
      </div>

      <!-- Confirm password -->
      <div class="relative">
        <label class="block mb-1 font-medium text-gray-700">Confirm Password</label>
        <input type="password" id="confirmPassword" minlength="8"
               class="w-full p-2 pr-12 rounded border focus:ring-2 focus:ring-red-500"
               placeholder="Repeat password">
        <button type="button" class="pwd-toggle absolute inset-y-0 right-0 flex items-center px-3"
                data-target="confirmPassword" title="Show / Hide">
          <i data-lucide="eye" class="w-5 h-5 text-gray-500"></i>
        </button>
      </div>

      <!-- spacer for equal grid -->
      <div></div>
    </div>

    <button class="bg-red-600 text-white font-semibold px-6 py-3 rounded hover:bg-red-700 transition"
            onclick="updatePassword()">
      Update Password
    </button>
  </div>

  <script>
    /* ─── Prefill read-only fields ─── */
    document.addEventListener('DOMContentLoaded', () => {
      ['name', 'username', 'role', 'user_id'].forEach(k => {
        const el = document.getElementById(k === 'user_id' ? 'id' : k);
        if (el) el.value = localStorage.getItem(k) || '';
      });
      lucide.createIcons();
    });

    /* ─── Eye toggle ─── */
    document.addEventListener('click', e => {
      const btn = e.target.closest('.pwd-toggle');
      if (!btn) return;

      const input = document.getElementById(btn.dataset.target);
      if (!input) return;

      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';

      // swap icon
      const icon = btn.querySelector('i');
      icon.setAttribute('data-lucide', show ? 'eye-off' : 'eye');
      lucide.createIcons({ icons: { 'eye': lucide.icons.eye, 'eye-off': lucide.icons['eye-off'] } });
    });

    /* ─── Live validation colours ─── */
    ['newPassword', 'confirmPassword'].forEach(id => {
      document.getElementById(id).addEventListener('input', validatePwds);
    });

    function validatePwds() {
      const np = document.getElementById('newPassword');
      const cp = document.getElementById('confirmPassword');
      const minLenOK = np.value.length >= 8 && cp.value.length >= 8;
      const match = np.value === cp.value && minLenOK;

      const warn = 'border-orange-400';
      const ok   = 'border-green-500';
      const neutral = 'border-gray-300';

      // util to swap Tailwind border classes
      const setBorder = (el, cls) => {
        el.classList.remove(warn, ok, neutral);
        el.classList.add(cls);
      };

      setBorder(np, np.value.length && np.value.length < 8 ? warn : neutral);
      setBorder(cp, cp.value ? (match ? ok : warn) : neutral);
      return match;
    }

    /* ─── Update password ─── */
    async function updatePassword() {
      if (!validatePwds()) {
        Swal.fire('Oops', 'Passwords must be at least 8 characters and match.', 'warning');
        return;
      }

      const uid   = localStorage.getItem('user_id');
      const token = localStorage.getItem('authToken');
      if (!uid || !token) {
        Swal.fire('Error', 'Not logged in.', 'error');
        return;
      }

      Swal.showLoading();

      try {
        const res = await fetch(`${BASE_URL}/user/${uid}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({ password: document.getElementById('newPassword').value })
        });
        const json = await res.json();

        if (json.success) {
          Swal.fire('Success', 'Password updated!', 'success');
          document.getElementById('newPassword').value = '';
          document.getElementById('confirmPassword').value = '';
          validatePwds();
        } else {
          throw new Error(json.message || 'Update failed');
        }
      } catch (err) {
        console.error(err);
        Swal.fire('Error', err.message || 'Server error', 'error');
      }
    }
  </script>
</body>
</html>
<!-- ╚══════════════════════════════════════════════╝ -->
