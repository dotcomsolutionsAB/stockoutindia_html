<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stockout India – Register</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Heroicons (for eye toggles) -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="uploads/favicon/apple-touch-icon.png">
</head>
<body class="bg-cover bg-center bg-no-repeat"
      style="background-image:url('https://www.stockoutindia.com/assets/img/contact-bg.png')">

  <!-- Overlay -->
  <div class="bg-red-900 bg-opacity-80 min-h-screen flex items-center justify-center">

    <!-- ❶ Left text / banner (hidden on ≤ md) -->
    <div class="w-1/2 text-white px-10 hidden md:block">
      <div class="max-w-md">
        <img src="uploads/stockout_logo.png" alt="Logo" class="mb-4 w-28">
        <h1 class="text-4xl font-bold mb-4">Stockout India</h1>
        <p class="text-lg leading-relaxed">
          The easiest way to sell your dead stock. <br>
          Join thousands of interested buyers.
        </p>
      </div>
    </div>

    <!-- ❷ Right-hand register card -->
    <div class="w-full md:w-1/2 px-4 md:px-10">
      <div class="bg-white rounded-xl p-8 md:p-8 shadow-lg max-w-2xl mx-auto">

        <h2 class="text-xl font-bold text-red-700 mb-6">Sign up to Stockout India</h2>

        <!-- ────────── REGISTER FORM ────────── -->
        <form id="registerForm" class="space-y-6">

          <!-- GST Opt-in / Opt-out -->
          <div class="flex items-center gap-2">
            <input id="noGstChk" type="checkbox" class="accent-red-600 rounded">
            <label for="noGstChk" class="text-sm select-none">
              I&nbsp;don’t have a&nbsp;GSTIN
            </label>
          </div>

          <!-- GST field (hidden when #noGstChk is checked) -->
          <div id="gstFieldGroup">
            <input type="text" placeholder="GSTIN"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
          </div>

          <!-- EXTRA FIELDS  (visible only when GST checkbox is checked) -->
          <div id="extraFields" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input type="text"  placeholder="Full Name"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <input type="text"  placeholder="Company Name"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
            </div>

            <textarea placeholder="Complete Address" rows="3"
                      class="w-full border border-gray-400 px-3 py-2 rounded-md resize-none mt-4"></textarea>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
              <input type="text" placeholder="Pincode"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <input type="text" placeholder="State"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
              <input type="text" placeholder="City"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md">
            </div>
          </div>

          <!-- BASIC FIELDS (shown in both paths) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text"     placeholder="Phone"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
            <input type="email"    placeholder="Email"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
            <!-- Password with eye toggle -->
            <div class="relative">
              <input id="pass" type="password" placeholder="Password"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md pr-10">
              <i data-feather="eye" class="eye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
            </div>
            <div class="relative">
              <input id="cpass" type="password" placeholder="Confirm Password"
                     class="w-full border border-gray-400 px-3 py-2 rounded-md pr-10">
              <i data-feather="eye" class="eye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
            </div>
          </div>

          <!-- Industry + Sub-industry -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" placeholder="Industry"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
            <input type="text" placeholder="Sub-Industry"
                   class="w-full border border-gray-400 px-3 py-2 rounded-md">
          </div>

          <!-- Terms -->
          <label class="flex items-start gap-2 text-sm mt-2 select-none">
            <input type="checkbox" required class="accent-red-600 mt-1 rounded">
            <span>
              By registering you confirm that you accept the
              <a href="#" class="text-red-600 font-medium">Terms & Conditions</a>
              and the
              <a href="#" class="text-red-600 font-medium">Privacy Policy</a>.
            </span>
          </label>

          <!-- Submit -->
          <button type="submit"
                  class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-full">
            Register
          </button>
        </form>

        <!-- Google Sign-up -->
        <button class="w-full border border-gray-300 flex items-center justify-center py-2 rounded-full mt-6 hover:shadow-md">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-2">
          <span class="text-sm font-medium">Sign in with Google</span>
        </button>

        <p class="text-sm text-gray-600 mt-4">
          Already have an account?
          <a href="login.php" class="text-red-600 font-semibold">Sign in</a>
        </p>
      </div>
    </div>
  </div>

  <!-- ───────────── INTERACTIVITY ───────────── -->
  <script>
    /* 1. show/hide GST + extra field groups */
    const noGstChk   = document.getElementById('noGstChk');
    const gstGroup   = document.getElementById('gstFieldGroup');
    const extraGroup = document.getElementById('extraFields');

    function syncVisibility() {
      const hideGst = noGstChk.checked;
      gstGroup.classList.toggle('hidden', hideGst);
      extraGroup.classList.toggle('hidden', !hideGst);
    }
    noGstChk.addEventListener('change', syncVisibility);
    syncVisibility();            // initialise on page load

    /* 2. password eye toggles (works for both pwd inputs) */
    document.querySelectorAll('.eye').forEach(eyeIcon => {
      eyeIcon.addEventListener('click', () => {
        const inp = eyeIcon.previousElementSibling;
        const type = inp.type === 'password' ? 'text' : 'password';
        inp.type = type;
        eyeIcon.dataset.feather = type === 'password' ? 'eye' : 'eye-off';
        feather.replace();       // re-draw icon
      });
    });

    /* 3. feather icons init */
    feather.replace();
  </script>
</body>
</html>
