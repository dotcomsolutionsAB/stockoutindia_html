<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forget Password - Stockout India</title>
  <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php include("configs/config_static_data.php"); ?>

<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('uploads/Stockout_bg.png');">
  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">
    <!-- Form Card -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-10 shadow-lg max-w-md mx-auto">
        <h2 class="text-xl font-bold text-red-700 mb-6 text-center">Forgot Password</h2>

        <form id="forgetPasswordForm">
          <p class="text-sm text-gray-700 mb-4">Enter your registered email address to receive reset instructions.</p>

          <div class="mb-4">
            <input type="email" name="email" id="email" placeholder="Email address" required
              class="w-full border border-gray-400 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" />
          </div>

          <button type="submit"
            class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            Send Reset Link
          </button>
        </form>

        <br>
        <p class="text-sm text-gray-600 text-center">
          Remembered your password?
          <a href="login" class="text-red-600 font-semibold">Sign in</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('forgetPasswordForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const username = document.getElementById('email').value.trim();

      try {
        const response = await fetch('<?php echo BASE_URL; ?>/forget_password', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ username })
        });

        const result = await response.json();

        if (result.success) {
          Swal.fire({
            icon: 'success',
            title: 'Email Sent',
            text: 'A reset link has been sent to your email.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#b91c1c'
          }).then(() => {
            window.location.href = "login";
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: result.message || 'Unable to send reset email.',
            confirmButtonColor: '#b91c1c'
          });
        }
      } catch (err) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Something went wrong. Please try again later.',
          confirmButtonColor: '#b91c1c'
        });
      }
    });
  </script>
</body>

</html>
