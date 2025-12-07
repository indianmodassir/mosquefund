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
          <div class="icon" style=""><i class="fa fa-key"></i></div>
          <div class="icon icon-eye" style="right: 0px; left: unset;" onclick="togglePassword(this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </div>
          <div class="error"></div>
        </div>
        <div class="field" style="column-gap: 0px; width: inherit; min-width: 120px;">
          <button type="button" id="otpSender" onclick="sendOTP()" style="display: flex; align-items: center; justify-content: center; column-gap: 6px; width: fit-content;padding: 0 15px;max-width: inherit;">
            <img class="preloader" src="/resources/assets/loader.gif" alt="Loader"/>
            <i class="fa fa-arrow-rotate-right"></i>
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
          <div class="icon"><i class="fa fa-hand-o-right"></i></div>
          <div class="error"></div>
        </div>
      </div>
      <div class="field last-field"style="flex-direction:row;">
        <button style="max-width:140px;display:flex;justify-content:center;align-items:center;column-gap:8px;">
          <img class="preloader" src="/resources/assets/loader.gif" alt="Loader"/>
          <i class="fa fa-floppy-o"></i>
          <span>CONTINUE</span>
        </button>
      </div>
    </form>
  </div>
</div>