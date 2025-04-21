<!-- Navbar with White Background -->
<nav class="bg-white shadow-md sticky top-0 z-10">
    <div class="flex justify-between items-center p-4">
        <!-- Mobile Hamburger -->
        <div class="lg:hidden flex items-center">
            <button id="hamburger" class="text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="I'm searching for..."
                class="px-4 py-2 rounded-lg border border-gray-300 w-600" />
        </div>

        <!-- Profile Dropdown Button -->
        <div class="relative">
            <button id="profileButton" class="flex items-center space-x-2 bg-red-600 text-white p-2 rounded-full">
                <span>Admin</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Content -->
            <div id="dropdownContent" class="dropdown-content absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                <a href="#settings" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="#privacy" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Privacy</a>
                <a href="#logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100" onclick="accLogout()">Logout</a>
            </div>
        </div>
    </div>
</nav>

<script>
    function accLogout() {
        localStorage.removeItem("authToken");
        localStorage.removeItem("user_id");
        localStorage.removeItem("role");
        localStorage.removeItem("username");
        localStorage.removeItem("name");

        window.location.href = "login.php";
    }
</script>