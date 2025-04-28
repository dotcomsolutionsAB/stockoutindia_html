<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stockout India - Login</title>
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
          The easiest way to sell your dead stock. <br />
          Join thousands of Interested buyers.
        </p>
      </div>
    </div>

    <!-- Right Login Section -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-10 shadow-lg max-w-md mx-auto">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold text-red-700">Sign in to Stockout India</h2>
        </div>

        <form id="loginForm">
          <p class="text-sm text-gray-700 mb-4">If you have an account with us, Please log in!</p>

          <!-- Input Type Switch -->
          <div class="flex mb-4">
            <button type="button" id="mobileButton" class="w-1/2 py-2 bg-red-700 text-white font-semibold rounded-l-md">
              <i class="fa-solid fa-phone"></i>
            </button>
            <button type="button" id="emailButton" class="w-1/2 py-2 bg-gray-500 text-white font-semibold rounded-r-md">
              <i class="fa-solid fa-envelope"></i>
            </button>
          </div>

          <!-- Mobile Input -->
          <div id="mobileInput" class="relative mb-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 text-sm font-medium">+91</span>
            <input type="tel" name="mobile" id="mobile" placeholder="Enter phone number"
              class="pl-12 w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <!-- Email Input -->
          <div id="emailInput" class="relative mb-4 hidden">
            <input type="email" name="email" id="email" placeholder="Enter Email Id"
              class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <!-- Password Input -->
          <div class="relative mb-4">
            <input type="password" name="password" id="password" placeholder="Password" required
              class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 pr-10" />
            <i id="togglePassword"
              class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer"
              onclick="togglePasswordVisibility()"></i>
          </div>

          <div class="flex justify-between items-center mb-4 text-sm">
            <a href="forget-password.php" class="text-red-600 font-semibold hover:underline">Forgot Your Password?</a>
          </div>

          <button type="submit"
            class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            Login
          </button>
        </form>

        <br>

        <!-- Google Sign-in -->
        <!-- <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mb-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button> -->
        <button id="googleSignInBtn" class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mb-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600">Don't have an account?
          <a href="register.php" class="text-red-600 font-semibold">Sign up</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    const mobileBtn = document.getElementById('mobileButton');
    const emailBtn = document.getElementById('emailButton');
    const mobileInputDiv = document.getElementById('mobileInput');
    const emailInputDiv = document.getElementById('emailInput');
    const mobile = document.getElementById('mobile');
    const email = document.getElementById('email');
    let selectedLoginType = 'mobile'; // default

    // Switch to mobile input
    mobileBtn.addEventListener('click', function () {
      mobileInputDiv.classList.remove('hidden');
      emailInputDiv.classList.add('hidden');

      mobileBtn.classList.add('bg-red-700');
      emailBtn.classList.remove('bg-red-700');
      mobileBtn.classList.remove('bg-gray-500');
      emailBtn.classList.add('bg-gray-500');

      // Validation
      mobile.setAttribute('required', 'required');
      mobile.setAttribute('pattern', '[0-9]{10}');
      email.removeAttribute('required');
      email.removeAttribute('pattern');

      selectedLoginType = 'mobile';
    });

    // Switch to email input
    emailBtn.addEventListener('click', function () {
      emailInputDiv.classList.remove('hidden');
      mobileInputDiv.classList.add('hidden');

      emailBtn.classList.add('bg-red-700');
      mobileBtn.classList.remove('bg-red-700');
      emailBtn.classList.remove('bg-gray-500');
      mobileBtn.classList.add('bg-gray-500');

      // Validation
      email.setAttribute('required', 'required');
      mobile.removeAttribute('required');
      mobile.removeAttribute('pattern');

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

      if (selectedLoginType === 'mobile' && mobile.value) {
        data = {
          username: `+91${mobile.value.trim()}`,
          password: passwordInput.value
        };
      } else if (selectedLoginType === 'email' && email.value) {
        data = {
          username: email.value.trim(),
          password: passwordInput.value
        };
      } else {
        alert("Please enter valid login credentials.");
        return;
      }

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

            if (role === 'admin') {
              window.location.href = 'admin/admin_index.php';
            } else {
              window.location.href = 'index.php';
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

<!-- Firebase SDK v8 -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>

<script>
    // Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCE5BPXYqHLQ0tgxYUoSHBHCDtBkr2547s",
        authDomain: "stockout-india.firebaseapp.com",
        projectId: "stockout-india",
        storageBucket: "stockout-india.firebasestorage.app",
        messagingSenderId: "391240277268",
        appId: "1:391240277268:web:9a11f9b8620cbc8a76b601"
    };
    
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const googleSignInBtn = document.getElementById("googleSignInBtn");

    googleSignInBtn.addEventListener("click", () => {
        const provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider)
            .then((result) => {
                const idToken = result.credential.idToken; // Get the ID token

                // Send the ID token to the backend for verification
                sendToBackend(idToken);
            })
            .catch((error) => {
                console.error("Error signing in with Google:", error);
            });
    });

    // Function to send the ID token to the backend
    function sendToBackend(idToken) {
        fetch('<?php echo BASE_URL; ?>/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                idToken: idToken,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from backend:', data);

            if (data.success) {
                if (data.account_created === false) {
                    // Show SweetAlert popup when user is not registered
                    Swal.fire({
                        title: 'You Have no Account!',
                        text: 'You have to register first.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Go to Register',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If "Go to Register" is clicked, redirect to registration page
                            window.location.href = 'register.php';
                        } else {
                            // If "Cancel" is clicked, stay on the login page
                            console.log('User cancelled registration');
                        }
                    });
                } else {
                    // User found and logged in
                    const { token, user_id, name, role, username } = data.data;

                    // Store user data in localStorage
                    localStorage.setItem('authToken', token);
                    localStorage.setItem('user_id', user_id);
                    localStorage.setItem('name', name);
                    localStorage.setItem('role', role);
                    localStorage.setItem('username', username);

                    // Redirect based on user role
                    if (role === 'admin') {
                        window.location.href = 'admin/admin_index.php';
                    } else {
                        window.location.href = 'index.php';
                    }
                }
            } else {
                // Handle error response
                alert(data.message || 'An error occurred, please try again.');
            }
        })
        .catch((error) => {
            console.error('Error sending data to backend:', error);
            alert('An error occurred while processing your login.');
        });
    }
</script>

</body>

</html>
