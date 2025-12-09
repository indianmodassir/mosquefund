<div id="window" style="width:100%;max-width:800px;">
<form action="track?stage=data_info" method="post">
  <strong>Track Registration Status</strong>
  <p>Check if your Registration is Delivered or Rejected.</p>
  <p>‘FRN’ followed by 11 digits, printed on acknowledgement slip while submitting online update request. Sample: REF20253675249</p>
  <div>
    <div class="input v-align">
      <input type="text" name="reference-number" value="{{session()->get('ref-no')}}" autocomplete="on" onfocus="this.placeholder='REF20253675249'" onblur="this.placeholder = ''" required>
      <span class="placeholder">Reference Number</span>
    </div>
    <div class="error">{{session()->get('ref-error')}}</div>
  </div>
  <div class="v-align" style="display:flex;column-gap: 33px;">
    <div style="flex-grow:1;">
      <div class="input">
        <input type="number" name="captcha" id="captcha" required>
        <span class="placeholder">Enter Captcha</span>
      </div>
      <div class="error">{{session()->get('captcha-error')}}</div>
    </div>
    <div class="captcha" style="display:flex;align-items:center;column-gap:8px;">
      <canvas height="40" width="170" style="background:#000;"></canvas>
      <img src="resources/assets/refresh_icon.png" draggable="false" alt="Refresh" style="cursor: pointer;" onclick="generateCaptcha()">
    </div>
  </div>
  <div class="st-group v-align" style="column-gap:11px;justify-content:flex-start;">
    <button>
      <i class="fa fa-floppy-o"></i>
      <span>SUBMIT</span>
    </button>
    <button type="reset">
      <i class="fa fa-circle-o"></i>
      <span>RESET</span>
    </button>
  </div>
</form>
<script src="/resources/js/App.js"></script>
<script>generateCaptcha()</script>
@php if ($stage === 'data_info') view('data_info'); @endphp
</div>