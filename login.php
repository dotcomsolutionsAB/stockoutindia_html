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

          <!-- Select Type of Input (Mobile / Email) -->
          <div class="flex mb-4">
            <button type="button" id="mobileButton" class="w-1/2 py-2 bg-red-700 text-white font-semibold rounded-l-md">
              Mobile
            </button>
            <button type="button" id="emailButton" class="w-1/2 py-2 bg-gray-300 text-gray-700 font-semibold rounded-r-md">
              Email
            </button>
          </div>

          <!-- For Mobile -->
          <div id="mobileInput" class="relative mb-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 text-sm font-medium">+91</span>
            <input type="tel" name="mobile" id="mobile" placeholder="Enter phone number" pattern="[0-9]{10}"
              
              class="pl-12 w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <!-- For Email -->
          <div id="emailInput" class="relative mb-4 hidden">
            <input type="email" name="email" id="email" placeholder="Enter Email Id" class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <!-- Password Field with Eye Icon -->
          <div class="relative mb-4">
            <input type="password" name="password" id="password" placeholder="Password" required
              class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 pr-10" />
            <!-- Toggle Eye Icon -->
            <i id="togglePassword"
              class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer"
              onclick="togglePasswordVisibility()"></i>
          </div>

          <div class="flex justify-between items-center mb-4 text-sm">
            <a href="forget-password.php" class="text-red-600 font-semibold hover:underline">Forgot Your Password?</a>
          </div>

          <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            login
          </button>
        </form>

        <br>

        <!-- Google Sign-in -->
        <button
          class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mb-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google"
            class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600">Don't have an account?
          <a href="register.php" class="text-red-600 font-semibold">Sign up</a>
        </p>
      </div>
    </div>
  </div>

  <!-- <script>
    // Toggle Mobile and Email input fields
    document.getElementById('mobileButton').addEventListener('click', function () {
      document.getElementById('mobileInput').classList.remove('hidden');
      document.getElementById('emailInput').classList.add('hidden');
      this.classList.add('bg-red-700');
      this.classList.remove('bg-gray-300');
      document.getElementById('emailButton').classList.add('bg-gray-300');
      document.getElementById('emailButton').classList.remove('bg-red-700');
      document.getElementById('email').removeAttribute('required');
      document.getElementById('mobile').setAttribute('required', 'required');
    });

    document.getElementById('emailButton').addEventListener('click', function () {
      document.getElementById('emailInput').classList.remove('hidden');
      document.getElementById('mobileInput').classList.add('hidden');
      this.classList.add('bg-red-700');
      this.classList.remove('bg-gray-300');
      document.getElementById('mobileButton').classList.add('bg-gray-300');
      document.getElementById('mobileButton').classList.remove('bg-red-700');
      document.getElementById('mobile').removeAttribute('required');
      document.getElementById('email').setAttribute('required', 'required');
    });

    // Toggle password visibility
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

    // Handle form submission
    document.getElementById('loginForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const mobileInput = document.getElementById('mobile');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      let inputData = '';

      if (mobileInput.value && !emailInput.value) {
        inputData = `Mobile: +91${mobileInput.value}, Password: ${passwordInput.value}`;
        alert(inputData + " - Mobile selected");
      } else if (emailInput.value && !mobileInput.value) {
        inputData = `Email: ${emailInput.value}, Password: ${passwordInput.value}`;
        alert(inputData + " - Email selected");
      }
    });
  </script> -->
  <!-- <script>
    // Toggle Mobile and Email input fields
    document.getElementById('mobileButton').addEventListener('click', function () {
      document.getElementById('mobileInput').classList.remove('hidden');
      document.getElementById('emailInput').classList.add('hidden');
      this.classList.add('bg-red-700');
      this.classList.remove('bg-gray-300');
      document.getElementById('emailButton').classList.add('bg-gray-300');
      document.getElementById('emailButton').classList.remove('bg-red-700');
      document.getElementById('email').removeAttribute('required');
      document.getElementById('mobile').setAttribute('required', 'required');
    });

    document.getElementById('emailButton').addEventListener('click', function () {
      document.getElementById('emailInput').classList.remove('hidden');
      document.getElementById('mobileInput').classList.add('hidden');
      this.classList.add('bg-red-700');
      this.classList.remove('bg-gray-300');
      document.getElementById('mobileButton').classList.add('bg-gray-300');
      document.getElementById('mobileButton').classList.remove('bg-red-700');
      document.getElementById('mobile').removeAttribute('required');
      document.getElementById('email').setAttribute('required', 'required');
    });

    // Toggle password visibility
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

    // Handle form submission
    document.getElementById('loginForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const mobileInput = document.getElementById('mobile');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      let data = {};

      // Determine whether mobile or email is used
      if (mobileInput.value && !emailInput.value) {
        // If mobile is selected
        data = {
          username: `+91${mobileInput.value}`,
          password: passwordInput.value
        };
      } else if (emailInput.value && !mobileInput.value) {
        // If email is selected
        data = {
          username: emailInput.value,
          password: passwordInput.value
        };
      }

      // Send login data to API
      fetch('<?php echo BASE_URL; ?>/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(result => {
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
            window.location.href = 'admin_index.php';  // Redirect to admin dashboard
          } else if (role === 'user') {
            window.location.href = 'index.php';  // Redirect to user dashboard
          } else {
            window.location.href = 'login.php';  // Default to login page if role is not recognized
          }
        } else {
          alert(result.message || 'Login failed!');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during login. Please try again.');
      });
    });
</script> -->
<script>
  const mobileBtn = document.getElementById('mobileButton');
  const emailBtn = document.getElementById('emailButton');
  const mobileInputDiv = document.getElementById('mobileInput');
  const emailInputDiv = document.getElementById('emailInput');
  const mobileInput = document.getElementById('mobile');
  const emailInput = document.getElementById('email');

  // Default selection - mobile
  let selectedLoginType = 'mobile';

  // Mobile tab click
  mobileBtn.addEventListener('click', function () {
    mobileInputDiv.classList.remove('hidden');
    mobileInputDiv.classList.add('block');
    emailInputDiv.classList.add('hidden');
    emailInputDiv.classList.remove('block');

    mobileBtn.classList.add('bg-red-700');
    mobileBtn.classList.remove('bg-gray-300');
    emailBtn.classList.add('bg-gray-300');
    emailBtn.classList.remove('bg-red-700');

    email.removeAttribute('required');
    mobile.setAttribute('required', 'required');

    selectedLoginType = 'mobile';
  });

  // Email tab click
  emailBtn.addEventListener('click', function () {
    emailInputDiv.classList.remove('hidden');
    emailInputDiv.classList.add('block');
    mobileInputDiv.classList.add('hidden');
    mobileInputDiv.classList.remove('block');

    emailBtn.classList.add('bg-red-700');
    emailBtn.classList.remove('bg-gray-300');
    mobileBtn.classList.add('bg-gray-300');
    mobileBtn.classList.remove('bg-red-700');

    mobile.removeAttribute('required');
    email.setAttribute('required', 'required');

    selectedLoginType = 'email';
  });

  // Toggle password visibility
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

  // Handle login
  document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const passwordInput = document.getElementById('password');
    let data = {};

    if (selectedLoginType === 'mobile' && mobileInput.value) {
      data = {
        username: `+91${mobileInput.value.trim()}`,
        password: passwordInput.value
      };
    } else if (selectedLoginType === 'email' && emailInput.value) {
      data = {
        username: emailInput.value.trim(),
        password: passwordInput.value
      };
    } else {
      alert("Please enter valid login credentials.");
      return;
    }

    console.log("Login Payload:", data); // Debugging purpose

    fetch('<?php echo BASE_URL; ?>/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          const { token, user_id, name, role, username } = result.data;

          localStorage.setItem('authToken', token);
          localStorage.setItem('user_id', user_id);
          localStorage.setItem('name', name);
          localStorage.setItem('role', role);
          localStorage.setItem('username', username);

          // Redirect based on role
          if (role === 'admin') {
            window.location.href = 'admin_index.php';
          } else if (role === 'user') {
            window.location.href = 'index.php';
          } else {
            window.location.href = 'login.php';
          }
        } else {
          alert(result.message || 'Login failed!');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during login. Please try again.');
      });
  });
</script>

</body>

</html>
