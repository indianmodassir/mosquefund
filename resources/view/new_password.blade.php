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
        <div class="icon"><i class="fa fa-key"></i></div>
        <div class="error"></div>
      </div>
      <div class="field">
        <input type="text" name="conf-password" id="confPass" placeholder="Confirm new password" autocomplete="off">
        <div class="icon"><i class="fa fa-key"></i></div>
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
          <div class="icon"><i class="fa fa-hand-o-right"></i></div>
          <div class="error"></div>
        </div>
      </div>
      <div class="field last-field"style="flex-direction:row;">
        <button style="max-width:140px;display:flex;justify-content:center;align-items:center;column-gap:8px;">
          <img class="preloader" src="/resources/assets/loader.gif" alt="Loader"/>
          <i class="fa fa-floppy-o"></i>
          <span>CREATE PASSWORD</span>
        </button>
      </div>
    </form>
  </div>
</div>