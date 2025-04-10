<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Stockout India - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
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

          <input type="text" name="username" id="username" placeholder="Email / Phone" required
                 class="w-full border border-gray-400 px-3 py-2 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-red-500" />
          <input type="password" name="password" id="password" placeholder="Password" required
                 class="w-full border border-gray-400 px-3 py-2 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-red-500" />

          <div class="flex justify-between items-center mb-4 text-sm">
            <label class="flex items-center">
              <input type="checkbox" class="mr-2">
              Remember Me
            </label>
            <a href="#" class="text-red-600 font-semibold hover:underline">Forgot Your Password?</a>
          </div>

          <button type="submit"
                  class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            login
          </button>
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
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value;

      try {
        const response = await fetch('https://your-api-url.com/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ username, password })
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

          // Redirect
          window.location.href = "profile.php";
        } else {
          alert(result.message || "Login failed!");
        }
      } catch (err) {
        console.error('Login Error:', err);
        alert("Something went wrong. Please try again later.");
      }
    });
  </script>
</body>
</html>
