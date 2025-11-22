<div id="content">
  <div class="header">
    <button type="button" class="close" onclick="closeModel()">
      <span aria-hidden="true">×</span>
    </button>
    <h4>OTP Verification</h4>
  </div>
  <div class="form-container">
    <form action="/forgot/reset/{{$role}}" onsubmit="submitLoginForm(event)">
      <input type="hidden" name="login-id" id="loginId" value="{{$auth_id}}" autocomplete="on">
      <input type="hidden" name="email-verification-id" value="{{$vid}}" autocomplete="off">
      <input type="hidden" name="role" id="role" value="{{$role}}" autocomplete="off">
      <input type="hidden" name="csrf" id="csrfToken" value="{{$csrf}}" autocomplete="off">
      <div class="group" style="align-items: center; justify-content: start;">
        <div class="field">
          <input type="password" name="otp" id="otp" placeholder="Enter OTP" autocomplete="off">
          <div class="icon">
            <svg width="22" height="22" viewBox="0 0 24 24" style="fill: currentcolor;"><path d="M7 17a5.007 5.007 0 0 0 4.898-4H14v2h2v-2h2v3h2v-3h1v-2h-9.102A5.007 5.007 0 0 0 7 7c-2.757 0-5 2.243-5 5s2.243 5 5 5zm0-8c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z"></path></svg>
          </div>
          <div class="icon icon-eye" style="right: 0px; left: unset;" onclick="togglePassword(this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </div>
          <div class="error"></div>
        </div>
        <div class="field" style="column-gap: 0px; width: inherit; min-width: 120px;">
          <button type="button" id="otpSender" onclick="sendOTP()" style="display: flex; align-items: center; justify-content: center; column-gap: 6px;">
            <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
          <span>Resend OTP</span>
          </button>
          <div class="status"></div>
        </div>
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
          <span>CONTINUE</span>
        </button>
      </div>
    </form>
  </div>
</div>