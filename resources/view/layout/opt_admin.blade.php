<div class="top-bar">
  <input type="hidden" id="control" name="control" value="Owner" autocomplete="off">
  <ul class="login-box" style="position:relative">
    <li>
      <div class="login multi-list hide" onclick="this.classList.toggle('hide')">{{$fullname}}<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></div>
      <ul class="login-options account-options">
        <li data-action="/admin/dashboard" onclick="sendOptRequest(this)">Dashboard</li>
        <li data-action="/admin/view_profile" onclick="sendOptRequest(this)">View Profile (Admin)</li>
        <li data-action="/admin/create" onclick="sendOptRequest(this)">Create Account</li>
        <li data-action="/admin/manage" onclick="sendOptRequest(this)">Manage Account</li>
        <li data-action="/admin/request" onclick="sendOptRequest(this)">Registration Reqeust</li>
        <li data-action="/admin/final_request" onclick="sendOptRequest(this)">Final Request</li>
        <li data-action="/admin/members" onclick="sendOptRequest(this)">Connected Members</li>
        <li data-action="/admin/all_request" onclick="sendOptRequest(this)">All Request Data</li>
        <li onclick="logout()">Logout</li>
      </ul>
    </li>
  </ul>
</div>