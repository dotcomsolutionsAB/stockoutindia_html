<div class="acc-user-info-box">
  <h2 class="acc-user-title">Account Information</h2>

  <div class="acc-user-row">
    <div class="acc-user-group">
      <label for="name">Name</label>
      <input type="text" id="name" class="acc-user-input" />
    </div>
    <div class="acc-user-group">
      <label for="username">Username</label>
      <input type="text" id="username" class="acc-user-input" />
    </div>
    <div class="acc-user-group">
      <label for="role">Role</label>
      <input type="text" id="role" class="acc-user-input" />
    </div>
  </div>

  <div class="acc-user-row">
    <div class="acc-user-group" hidden>
      <label for="id">ID</label>
      <input type="text" id="id" class="acc-user-input" />
    </div>
    <div class="acc-user-group">
      <!-- Empty for layout balance -->
    </div>
    <div class="acc-user-group">
      <!-- Empty for layout balance -->
    </div>
  </div>

  <button class="acc-user-btn" onclick="updateAccountInfo()">Update</button>
</div>

<script>
  // Auto-fill inputs from localStorage on page load
  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('name').value = localStorage.getItem('name') || '';
    document.getElementById('id').value = localStorage.getItem('user_id') || '';
    document.getElementById('role').value = localStorage.getItem('role') || '';
    document.getElementById('username').value = localStorage.getItem('username') || '';
  });

  // Update localStorage from input values
  function updateAccountInfo() {
    localStorage.setItem('name', document.getElementById('name').value);
    localStorage.setItem('id', document.getElementById('user_id').value);
    localStorage.setItem('role', document.getElementById('role').value);
    localStorage.setItem('username', document.getElementById('username').value);
    alert('Account information updated successfully!');
  }
</script>