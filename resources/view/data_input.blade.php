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
            <i class="fa fa-floppy-o"></i>
            <span>SUBMIT</span>
          </button>
          <button type="reset">
            <i class="fa fa-circle-o"></i>
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