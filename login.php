<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stockout India - Login</title>
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<?php include("configs/config_static_data.php"); ?>

<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('uploads/Stockout_bg.png');">

  <!-- Overlay -->
  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">

    <!-- Left Text Section -->
    <div class="w-1/2 text-white px-10 hidden md:block">
      <div class="max-w-md">
        <img src="uploads/stockout_logo.png" alt="Logo" class="mb-6 w-28">
        <h1 class="text-4xl font-bold mb-4">Stockout India</h1>
        <p class="text-lg">
          The easiest way to sell your dead stock. <br />
          Join thousands of Interested buyers.
        </p>
      </div>
    </div>

    <!-- Right Login Card -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-10 shadow-lg max-w-md mx-auto">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold text-red-700">Sign in to Stockout India</h2>
        </div>

        <!-- Login Form -->
        <form id="loginForm">
          <p class="text-sm text-gray-700 mb-4">If you have an account with us, Please log in!</p>

          <!-- Tabs: Mobile or Email -->
          <div class="flex border-b border-gray-400 mb-4">
            <button type="button" id="mobileTab" class="w-1/2 py-2 text-center text-sm font-medium text-gray-700 focus:outline-none" onclick="showTab('mobile')">Mobile</button>
            <button type="button" id="emailTab" class="w-1/2 py-2 text-center text-sm font-medium text-gray-700 focus:outline-none" onclick="showTab('email')">Email</button>
          </div>

          <!-- Input Fields -->
          <!-- Mobile Input -->
          <div id="mobileField" class="tab-content relative mb-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 text-sm font-medium" id="prefix">+91</span>
            <input type="tel" name="mobile" id="mobileNumber" placeholder="Enter phone number" pattern="[0-9]{10}" required class="pl-12 w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <!-- Email Input -->
          <div id="emailField" class="tab-content mb-4 hidden">
            <input type="email" name="email" id="email" placeholder="Enter email" required class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <!-- Password Field with Eye Icon -->
          <div class="relative mb-4">
            <input type="password" name="password" id="password" placeholder="Password" required class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 pr-10" />
            <!-- Toggle Eye Icon -->
            <i id="togglePassword" class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer" onclick="togglePasswordVisibility()"></i>
          </div>

          <div class="flex justify-between items-center mb-4 text-sm">
            <a href="forget-password.php" class="text-red-600 font-semibold hover:underline">Forgot Your Password?</a>
          </div>

          <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">Login</button>
        </form>

        <br>

        <!-- Google Sign-in -->
        <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mb-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600">Don't have an account?
          <a href="register.php" class="text-red-600 font-semibold">Sign up</a>
        </p>
      </div>
    </div>
  </div>

  <!-- JS: Login Logic -->
  <script>
    function togglePasswordVisibility() {
      const input = document.getElementById('password');
      const icon = document.getElementById('togglePassword');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

  function showTab(type) {
    const mobileTab = document.getElementById('mobileTab');
    const emailTab = document.getElementById('emailTab');
    const mobileField = document.getElementById('mobileField');
    const emailField = document.getElementById('emailField');

    // Reset all tabs to hidden
    mobileField.classList.add('hidden');
    emailField.classList.add('hidden');

    // Remove active class from both tabs
    mobileTab.classList.remove('text-red-700', 'font-semibold');
    emailTab.classList.remove('text-red-700', 'font-semibold');

    // Show the selected tab content
    if (type === 'mobile') {
      mobileField.classList.remove('hidden');
      mobileTab.classList.add('text-red-700', 'font-semibold');
      document.getElementById('mobileNumber').setAttribute('placeholder', 'Enter phone number');
      document.getElementById('mobileNumber').focus(); // Focus on mobile input field
    } else {
      emailField.classList.remove('hidden');
      emailTab.classList.add('text-red-700', 'font-semibold');
      document.getElementById('mobileNumber').setAttribute('placeholder', 'Enter email');
      document.getElementById('email').focus(); // Focus on email input field
    }
  }

  function showTab(type) {
    const mobileTab = document.getElementById('mobileTab');
    const emailTab = document.getElementById('emailTab');
    const mobileField = document.getElementById('mobileField');
    const emailField = document.getElementById('emailField');

    // Reset all tabs to hidden
    mobileField.classList.add('hidden');
    emailField.classList.add('hidden');

    // Remove active class from both tabs
    mobileTab.classList.remove('text-red-700', 'font-semibold');
    emailTab.classList.remove('text-red-700', 'font-semibold');

    // Show the selected tab content
    if (type === 'mobile') {
      mobileField.classList.remove('hidden');
      mobileTab.classList.add('text-red-700', 'font-semibold');
      document.getElementById('mobileNumber').setAttribute('placeholder', 'Enter phone number');
      document.getElementById('mobileNumber').focus(); // Focus on mobile input field
    } else {
      emailField.classList.remove('hidden');
      emailTab.classList.add('text-red-700', 'font-semibold');
      document.getElementById('mobileNumber').setAttribute('placeholder', 'Enter email');
      document.getElementById('email').focus(); // Focus on email input field
    }
  }

  // Default to showing the mobile tab
  document.addEventListener('DOMContentLoaded', function () {
    showTab('mobile');
  });

  document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    let username;
    const usernameOption = document.querySelector('input[name="mobile"]') ? 'mobile' : 'email';  // Determine which field is visible

    if (usernameOption === 'email') {
      username = document.getElementById('email').value.trim();
    } else {
      username = `+91${document.getElementById('mobileNumber').value.trim()}`;  // prepend +91 for mobile
    }

    const password = document.getElementById('password').value;

    try {
      const response = await fetch('<?php echo BASE_URL; ?>/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, password }),
      });

      const result = await response.json();

      if (result.success) {
        const { token, user_id, name, role, username } = result.data;

        // Save to localStorage
        localStorage.setItem('authToken', token);
        localStorage.setItem('user_id', user_id);
        localStorage.setItem('name', name);
        localStorage.setItem('role', role);
        localStorage.setItem('username', username);

        // Redirect based on role
        if (role === 'admin') {
          window.location.href = "admin/index.php";
        } else {
          window.location.href = "index.php";
        }
      } else {
        window.location.href = "login.php";
      }
    } catch (err) {
      console.error('Login Error:', err);
      alert("Something went wrong. Please try again later.");
    }
  });


  </script>
</body>

</html>
