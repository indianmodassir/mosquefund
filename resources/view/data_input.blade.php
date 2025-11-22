<div id="window">
  <div style="border-bottom:1px solid #ccc;">
    <div class="st-group status-step {{$stage}}">
      <div class="img-wrap">
        <div class="step-img">
          <a href="track?stage=data_input">
            <img src="/resources/assets/status_input.png" alt="Status Input" draggable="false">
          </a>
        </div>
        <div class="status-label">Application Details</div>
      </div>
      <div class="img-wrap">
        <div class="step-img">
          <img src="/resources/assets/status_info.png" alt="Status Info" draggable="false">
        </div>
        <div class="status-label">Application Status</div>
      </div>
    </div>
  </div>
@if ($stage === 'data_input')
<form action="track?stage=data_info" method="post">
  <table class="tracker data-input">
    <tr>
      <td>Track Application Option *</td>
      <td>
        <div class="st-group" style="justify-content:start;column-gap:8px;">
          <input type="radio" id="track_opt" checked>
          <label for="track_opt">Through Application Reference Number</label>
        </div>
      </td>
    </tr>
    <tr>
      <td>Application Reference Number *</td>
      <td>
        <input type="text" name="reference-number" value="{{session()->get('ref-no')}}" autocomplete="on">
        <div class="error">{{session()->get('ref-error')}}</div>
      </td>
    </tr>
    <tr>
      <td style="vertical-align:top;">Captcha Verification *</td>
      <td>
        <div class="captcha" style="display:flex;align-items:center;column-gap:8px;">
          <canvas height="40" width="170" style="background:#000;"></canvas>
          <img src="resources/assets/refresh_icon.png" draggable="false" alt="Refresh" style="cursor: pointer;" onclick="generateCaptcha()">
        </div>
        <div style="margin:20px 0;">
          <p style="margin-bottom:8px;">Please enter the characters shown above</p>
          <div>
            <input type="number" name="captcha" id="captcha">
            <div class="error">{{session()->get('captcha-error')}}</div>
          </div>
        </div>
        <div class="st-group" style="column-gap:11px;justify-content:flex-start;">
          <button>
            <svg width="16px" height="16px" viewBox="0 0 24 24" fill="currentColor" style="transform: rotateY(180deg);">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3572 3.23397C3.66645 2.97447 4.1014 2.92638 4.45988 3.11204L20.7851 11.567C21.1426 11.7522 21.3542 12.1337 21.322 12.5351C21.2898 12.9364 21.02 13.2793 20.6375 13.405L13.7827 15.6586L10.373 22.0179C10.1828 22.3728 9.79826 22.5789 9.39743 22.541C8.9966 22.503 8.65762 22.2284 8.53735 21.8441L3.04564 4.29872C2.92505 3.91345 3.04794 3.49346 3.3572 3.23397ZM5.67123 5.99173L9.73507 18.9752L12.2091 14.361C12.3304 14.1347 12.5341 13.9637 12.7781 13.8835L17.7518 12.2484L5.67123 5.99173Z" fill="currentColor"></path>
            </svg>
            <span>SUBMIT</span>
          </button>
          <button type="reset">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"/></svg>
            <span>RESET</span>
          </button>
        </div>
      </td>
    </tr>
  </table>
</form>
<script src="/resources/js/App.js"></script>
<script>generateCaptcha()</script>
@else
@php view('data_info') @endphp
@endif
</div>