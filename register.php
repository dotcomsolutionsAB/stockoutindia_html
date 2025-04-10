<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Stockout India - Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('https://www.stockoutindia.com/assets/img/contact-bg.png');">
  
  <!-- Overlay -->
  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">

    <!-- Left Text Section -->
    <div class="w-1/2 text-white px-10 hidden md:block">
      <div class="max-w-md">
        <img src="uploads/stockout_logo.png" alt="Logo" class="mb-4 w-28">
        <h1 class="text-4xl font-bold mb-4">Stockout India</h1>
        <p class="text-lg">
          The easiest way to sell your dead stock. <br />
          Join thousands of Interested buyers.
        </p>
      </div>
    </div>

    <!-- Right Register Card -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-8 shadow-lg max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-red-700">Sign up to Stockout India</h2>
          <!-- <p class="text-sm text-gray-600">already have an account? <a href="login.php" class="text-red-600 font-semibold">Sign in</a></p> -->
        </div>
        <!-- Registration Form -->
        <form class="space-y-6">
          <!-- Grid Fields -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" placeholder="Full Name here.." class="w-full border border-gray-400 px-3 py-2 rounded-md" />
            <input type="email" placeholder="Email Address.." class="w-full border border-gray-400 px-3 py-2 rounded-md" />
            <input type="text" placeholder="Phone Number.." class="w-full border border-gray-400 px-3 py-2 rounded-md" />
            <input type="text" placeholder="Company Name.." class="w-full border border-gray-400 px-3 py-2 rounded-md" />
            <input type="text" placeholder="GST No." class="w-full border border-gray-400 px-3 py-2 rounded-md" />
            <div>
              <input type="text" placeholder="Select Industries" class="w-full border border-gray-400 px-3 py-2 rounded-md" />
              <p class="text-xs text-gray-500 mt-1">You can select maximum of 3 industries</p>
            </div>
          </div>

          <!-- Full-width fields -->
          <textarea placeholder="Complete Address" rows="3" class="w-full border border-gray-400 px-3 py-2 rounded-md resize-none"></textarea>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="password" placeholder="Password" class="w-full border border-gray-400 px-3 py-2 rounded-md" />
            <input type="password" placeholder="Confirm Password" class="w-full border border-gray-400 px-3 py-2 rounded-md" />
          </div>

          <!-- Terms and Conditions -->
          <div class="text-sm flex items-start gap-2 mt-2">
            <input type="checkbox" class="mt-1">
            <p>
              By registering you confirm that you accept the 
              <a href="#" class="text-red-600 font-medium">Terms and Conditions</a> and 
              <a href="#" class="text-red-600 font-medium">Privacy Policy</a>
            </p>
          </div>

          <!-- Register Button -->
          <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full mt-2">
            Register
          </button>
        </form>
        <br>
        <!-- Google Sign-up -->
        <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mb-4 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600">already have an account? <a href="login.php" class="text-red-600 font-semibold">Sign in</a></p>
      </div>
    </div>
  </div>
</body>
</html>
