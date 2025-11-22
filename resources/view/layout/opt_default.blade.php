<div class="top-bar">
  <ul class="login-box" style="position:relative;display:flex;column-gap:11px;align-items:center;">
    <li data-csrf="{{@csrf}}">
      <a href="/Reg8Yecd" id="secretary" target="_blank" style="color:inherit;">Secretary Registration</a>
    </li>
    <li data-csrf="{{@csrf}}" id="track_status" onclick="openWindow()">Track Registration Status</li>
    <li data-login="download" id="rcpt_download" data-csrf="{{@csrf}}" onclick="login(this)">Download Reciept</li>
    <li data-login="reciept" id="check_reciept" data-csrf="{{@csrf}}" onclick="login(this)">Check Reciept</li>
    <li>
      <div class="login multi-list hide" onclick="this.classList.toggle('hide')">Login<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></div>
      <ul class="login-options">
        <li data-login="admin" id="admin_login" data-csrf="{{@csrf}}" onclick="login(this)">Admin Login</li>
        <li data-login="owner" id="secretary_login" data-csrf="{{@csrf}}" onclick="login(this)">Secretary Login</li>
        <li data-login="collector" id="collector_login" data-csrf="{{@csrf}}" onclick="login(this)">Collector Login</li>
        <li data-login="member" id="member_login" data-csrf="{{@csrf}}" onclick="login(this)">Member Login</li>
      </ul>
    </li>
  </ul>
</div>