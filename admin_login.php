<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stockout India - Admin Login as User</title>
  <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php include("configs/config_static_data.php"); ?>

<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('uploads/Stockout_bg.png');">

  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">
    <!-- Left Section -->
    <div class="w-1/2 text-white px-10 hidden md:block">
      <div class="max-w-md">
        <img src="uploads/stockout_logo.png" alt="Logo" class="mb-6 w-28">
        <h1 class="text-4xl font-bold mb-4">Stockout India</h1>
        <p class="text-lg">
          Admin override panel.<br />
          Securely login as a user using super password.
        </p>
      </div>
    </div>

    <!-- Right Admin Login Section -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-10 shadow-lg max-w-md mx-auto">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold text-red-700">Admin: Login as User</h2>
        </div>

        <form id="adminLoginForm">
          <p class="text-sm text-gray-700 mb-4" id="impersonateText" hidden>
            Logging in as selected user…
          </p>

          <!-- Hidden user_id from query params -->
          <input type="hidden" id="user_id" name="user_id">

          <!-- Super Password Input -->
          <div class="relative mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
              Super Password
            </label>
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Enter super password"
              required
              class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 pr-10"
            />
            <i
              id="togglePassword"
              class="fa-solid fa-eye absolute right-3 top-9 text-gray-500 cursor-pointer"
            ></i>
          </div>

          <button
            type="submit"
            class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full"
          >
            Login as User
          </button>

          <p class="text-xs text-gray-500 mt-3">
            This action is logged. Use only for support/debugging.
          </p>
        </form>
      </div>
    </div>
  </div>

  <script>
    const BASE_URL = '<?php echo BASE_URL; ?>';

    // Toggle password visibility
    (function setupPasswordToggle() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('togglePassword');

      icon.addEventListener('click', () => {
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    })();

    // Get user_id from URL params and set hidden input
    (function initUserIdFromParams() {
      const params = new URLSearchParams(window.location.search);
      const userIdParam = params.get('user_id');
      const userIdInput = document.getElementById('user_id');
      const txt = document.getElementById('impersonateText');

      if (!userIdParam) {
        // No user_id – this page doesn't make sense
        txt.textContent = 'Missing user_id parameter in URL.';
        Swal.fire({
          icon: 'error',
          title: 'Invalid Access',
          text: 'No user selected to login as.'
        });
        return;
      }

      userIdInput.value = userIdParam;
      txt.textContent = `You are about to login as user ID: ${userIdParam}`;
    })();

    // Handle admin override login
    document.getElementById('adminLoginForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const userId       = document.getElementById('user_id').value;
      const superPassRaw = document.getElementById('password').value.trim();

      if (!userId) {
        Swal.fire({
          icon: 'error',
          title: 'Missing User',
          text: 'User ID is missing. Please reopen this page from admin panel.'
        });
        return;
      }

      if (!superPassRaw) {
        Swal.fire({
          icon: 'warning',
          title: 'Password Required',
          text: 'Please enter the super password.'
        });
        return;
      }

      // Optional: show loading
      Swal.fire({
        title: 'Logging in...',
        text: 'Verifying super password',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      try {
        const res = await fetch(`${BASE_URL}/admin/login-as-user`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            user_id: Number(userId),
            super_password: superPassRaw
          })
        });

        const result = await res.json();
        Swal.close();

        if (result.success) {
          const { token, user_id, name, role, username, email } = result.data;

          // Save to localStorage
          localStorage.setItem('authToken', token);
          localStorage.setItem('user_id', user_id);
          localStorage.setItem('name', name ?? '');
          localStorage.setItem('role', role ?? '');
          localStorage.setItem('username', username ?? '');
          if (email) {
            localStorage.setItem('email', email);
          }

          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: result.message || 'Logged in as user successfully.',
            timer: 1200,
            showConfirmButton: false
          });

          // Redirect to index page after short delay
          setTimeout(() => {
            window.location.href = 'index';
          }, 1200);

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: result.message || 'Invalid super password.'
          });
        }
      } catch (error) {
        console.error('Error during admin login-as-user:', error);
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred. Please try again.'
        });
      }
    });
  </script>

</body>
</html>
