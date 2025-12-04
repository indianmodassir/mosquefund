<div class="wrap bg" style="padding:11px 22px;background:#fbfbfb;">
  <form>
    <div class="label" style="text-align:start;">
      <strong>OTP verification</strong>
    </div>
    <div class="group" style="align-items: center; justify-content: start;">
      <div class="field" style="max-width: 240px;">
        <input type="password" data-type="password" id="otp" name="otp" placeholder="Enter OTP" autocomplete="off" style="padding: 0 11px 0 48px;">
        <div class="icon">
          <svg width="22" height="22" viewBox="0 0 24 24" style="fill: currentcolor;">
            <path
              d="M7 17a5.007 5.007 0 0 0 4.898-4H14v2h2v-2h2v3h2v-3h1v-2h-9.102A5.007 5.007 0 0 0 7 7c-2.757 0-5 2.243-5 5s2.243 5 5 5zm0-8c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z"
            ></path>
          </svg>
        </div>
        <div class="icon icon-eye" style="right: 0px; left: unset;" onclick="togglePassword(this)">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
            <path
              d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"
            ></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
          </svg>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </div>
        <div class="error"></div>
      </div>
      <div class="field" style="column-gap: 0px; width: auto; min-width: 120px;">
        <button style="max-width:max-content;width:max-content;padding:0 11px;display:flex;justify-content:center;align-items:center;column-gap:5px;" type="button" id="otpSender" onclick="sendOTP('/resendotp')"
          style="display: flex; align-items: center; justify-content: center; column-gap: 6px;width: fit-content;padding: 0 15px;max-width: inherit;">
          <img class="preloader" src="/resources/assets/loader.gif" alt="Loader"/>
          <i class="fa fa-arrow-rotate-right"></i>
          <span>RESEND OTP</span>
        </button>
        <div class="status" style="font-size:13px;margin-top:2px;"></div>
      </div>
    </div><br/>
    <div class="label" style="text-align:start;">
      <strong>Captcha verification</strong>
    </div>
    <div class="group" style="align-items: center; row-gap: 30px;justify-content:flex-start;">
      <div class="captcha" style="flex-direction:column;">
        <span>
          <canvas class="f-canvas" height="40" width="170"></canvas>
          <img src="resources/assets/refresh_icon.png" draggable="false" alt="Refresh" style="cursor: pointer;"
            onclick="generateCaptcha()">
        </span>
        <div style="margin-top:8px;font-size:14px;">Please enter the characters shown above</div>
      </div>
      <div class="captcha-input" style="position: relative;">
        <input type="text" name="captcha" id="captcha" autocomplete="off" style="max-width:150px;">
        <div class="error"></div>
      </div>
    </div>
  </form>
</div>
<div class="wrap bg" style="background:#fbfbfb;">
  <form action="/verifyotp" method="post" onsubmit="registration(event, false, true)" style="padding:0;">
    <div class="field"
      style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;column-gap:6px;">
      <button style="width:max-content;padding:0 14px;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <img class="preloader" src="/resources/assets/loader.gif" alt="Loader"/>
        <i class="fa fa-location-arrow"></i>
        <span>VERIFY OTP</span>
      </button>
      <button data-action="/admin/dashboard" onclick="sendOptRequest(this)" type="button"
        style="width:max-content;background:#e54a4a;padding:0 14px;">
        <i class="fa fa-times-circle"></i>
        <span>&nbsp;CLOSE</span>
      </button>
    </div>
  </form>
<script>
  generateCaptcha();
</script>
</div>