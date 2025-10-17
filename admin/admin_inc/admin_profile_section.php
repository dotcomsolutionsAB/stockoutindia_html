<div id="profile" class="tab-content">
    <h2 class="text-2xl font-semibold text-red-600 mb-6">Profile</h2>
    <form>
        <!-- Username and User ID -->
        <div class="mb-4 flex space-x-4">
            <div class="flex-1">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" disabled />
            </div>
            <!-- <div class="flex-1">
                <label for="user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                <input type="text" id="user_id" name="user_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" disabled />
            </div> -->
        </div>

        <!-- Name and Role -->
        <div class="mb-4 flex space-x-4">
            <div class="flex-1">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" disabled />
            </div>
            <div class="flex-1">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <input type="text" id="role" name="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" disabled />
            </div>
        </div>

        <!-- Auth Token -->
        <!-- <div class="mb-4">
            <label for="authToken" class="block text-sm font-medium text-gray-700">Auth Token</label>
            <input type="text" id="authToken" name="authToken" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" disabled />
        </div> -->
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Retrieve data from localStorage
        const username = localStorage.getItem('username');
        // const user_id = localStorage.getItem('user_id');
        const name = localStorage.getItem('name');
        const role = localStorage.getItem('role');
        // const authToken = localStorage.getItem('authToken');

        // Set the values in the input fields
        document.getElementById('username').value = username ? username : 'Not Available';
        // document.getElementById('user_id').value = user_id ? user_id : 'Not Available';
        document.getElementById('name').value = name ? name : 'Not Available';
        document.getElementById('role').value = role ? role : 'Not Available';
        // document.getElementById('authToken').value = authToken ? authToken : 'Not Available';
    });
</script>
