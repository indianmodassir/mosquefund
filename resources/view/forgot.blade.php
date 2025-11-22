<div id="content">
  <div class="header">
    <button type="button" class="close" onclick="closeModel()">
      <span aria-hidden="true">×</span>
    </button>
    <h4>Forgotten {{$role === 'owner' ? 'Secretary' : $role}}</h4>
  </div>
  <div class="form-container">
    <form action="/forgot/{{\strtolower($role)}}" onsubmit="submitLoginForm(event)">
      <input type="hidden" name="role" id="role" value="{{\strtolower($role)}}" autocomplete="off">
      <input type="hidden" name="csrf" id="csrfToken" value="{{$csrf}}" autocomplete="off">
      <div class="p-status">
        <div class="status"></div>
      </div>
      <div class="field">
        <input type="text" name="login-id" id="loginId" placeholder="Login ID" autocomplete="on">
        <div class="icon">
          <svg width="24" height="24" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path></svg>
        </div>
        <div class="error"></div>
      </div>
      <div class="group" style="align-items:center;">
        <div class="captcha">
          <span>
            <canvas height="46" width="180"></canvas>
            <img src="resources/assets/refresh_b.png" draggable="false" alt="Refresh" style="cursor:pointer" onclick="generateCaptcha()">
          </span>
        </div>
        <div class="captcha-input" style="position:relative;">
          <input type="text" name="captcha" id="captcha" placeholder="Enter Captcha" autocomplete="off">
          <div class="icon">
            <svg width="22" height="22" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="M20 8H8l1.212-3.03a2 2 0 0 0-1.225-2.641l-.34-.113a.998.998 0 0 0-1.084.309L2.231 7.722a1.001 1.001 0 0 0-.231.64V19a2 2 0 0 0 2 2h7.21a2 2 0 0 0 1.987-1.779L14 12h6a2 2 0 0 0 0-4z"></path></svg>
          </div>
          <div class="error"></div>
        </div>
      </div>
      <div class="field last-field"style="flex-direction:row;">
        <button style="max-width:140px;display:flex;justify-content:center;align-items:center;column-gap:8px;">
          <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
          <svg width="20px" height="20px" viewBox="0 0 24 24" fill="currentColor" style="transform:rotateY(180deg)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3572 3.23397C3.66645 2.97447 4.1014 2.92638 4.45988 3.11204L20.7851 11.567C21.1426 11.7522 21.3542 12.1337 21.322 12.5351C21.2898 12.9364 21.02 13.2793 20.6375 13.405L13.7827 15.6586L10.373 22.0179C10.1828 22.3728 9.79826 22.5789 9.39743 22.541C8.9966 22.503 8.65762 22.2284 8.53735 21.8441L3.04564 4.29872C2.92505 3.91345 3.04794 3.49346 3.3572 3.23397ZM5.67123 5.99173L9.73507 18.9752L12.2091 14.361C12.3304 14.1347 12.5341 13.9637 12.7781 13.8835L17.7518 12.2484L5.67123 5.99173Z" fill="currentColor"/>
          </svg>
          <span>SUBMIT</span>
        </button>
      </div>
      <div class="field" style="justify-content:center;flex-direction:row;">
        <a data-login="/login/{{\strtolower($role)}}" onclick="login(this)">Back to LogIn</a>
      </div>
    </form>
  </div>
</div>