<div id="content">
  <div class="header">
    <button type="button" class="close" onclick="closeModel()">
      <span aria-hidden="true">×</span>
    </button>
    <h4>Forgotten {{$role}}</h4>
  </div>
  <div class="form-container">
    <form action="/forgot/reset/newpassword/{{\strtolower($role)}}" onsubmit="submitLoginForm(event)">
      <input type="hidden" name="vid-token" value="{{$vid_token}}" autocomplete="off">
      <input type="hidden" name="role" id="role" value="{{\strtolower($role)}}" autocomplete="off">
      <input type="hidden" name="csrf" id="csrfToken" value="{{$csrf}}" autocomplete="off">
      <div class="p-status">
        <div class="status"></div>
      </div>
      <div class="field">
        <input type="text" name="password" id="password" placeholder="New password" autocomplete="off">
        <div class="icon">
          <svg width="22" height="22" viewBox="0 0 24 24" style="fill: currentcolor;"><path d="M7 17a5.007 5.007 0 0 0 4.898-4H14v2h2v-2h2v3h2v-3h1v-2h-9.102A5.007 5.007 0 0 0 7 7c-2.757 0-5 2.243-5 5s2.243 5 5 5zm0-8c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z" style=""></path></svg>
        </div>
        <div class="error"></div>
      </div>
      <div class="field">
        <input type="text" name="conf-password" id="confPass" placeholder="Confirm new password" autocomplete="off">
        <div class="icon">
          <svg width="22" height="22" viewBox="0 0 24 24" style="fill: currentcolor;"><path d="M7 17a5.007 5.007 0 0 0 4.898-4H14v2h2v-2h2v3h2v-3h1v-2h-9.102A5.007 5.007 0 0 0 7 7c-2.757 0-5 2.243-5 5s2.243 5 5 5zm0-8c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z" style=""></path></svg>
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
          <svg class="preloader" viewBox="0 0 19 19" fill="none" style=""><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square" style=""></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square" style=""></path></svg>
          <span>CREATE PASSWORD</span>
        </button>
      </div>
    </form>
  </div>
</div>