<div class="top-bar">
  <input type="hidden" id="control" name="control" value="Member" autocomplete="off">
  <ul class="login-box" style="position:relative">
    <li>
      <div class="login multi-list hide" onclick="this.classList.toggle('hide')">Collector<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></div>
      <ul class="login-options account-options">
        <li data-action="/collector/dashboard" onclick="sendOptRequest(this)">Dashboard</li>
        <li data-action="/collector/find" onclick="sendOptRequest(this)">Find Member</li>
        <li data-action="/collector/all" onclick="sendOptRequest(this)">All Members</li>
        <li onclick="logout()">Logout</li>
      </ul>
    </li>
  </ul>
</div>