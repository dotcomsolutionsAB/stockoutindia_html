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
