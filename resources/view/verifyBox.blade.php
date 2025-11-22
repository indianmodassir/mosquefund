<style>
.trp-btn {
  font-size: 15px;
  text-shadow: 0 1px 1px #000000;
  color: #fff;
  height: 38px;
  padding:0 15px;
  border-radius: 3px;
  border: 1px solid transparent;
  background: rgb(60, 141, 188);
  border-color: #367fa9;
}
.trp-btn:last-child {
  background: #dd4b39;
  border-color: #d73925;
}
.success {
  font-size: 14px;
  margin-top: 3px;
  color: #0abd0a;
}
</style>
<div id="content" style="background:linear-gradient(#0eafde, #022d4a);max-width:500px;">
  <div class="header" style="height:57px;">
    <h4 style="text-align:start;font-size:18px;color:#fff;font-weight:500;">OTP Verification</h4>
  </div>
  <div style="padding:0;">
    <div style="background:#f0f0f0;padding:15px;">
      <p style="font-size:15px;">An OTP has been sent to your email address {{$masked_email}}. Please note that the OTP received is for single use only and is valid for 15 minutes from the time of request.</p>
      <div class="group" style="margin:15px 0;padding:0 15px;justify-content:flex-start;align-items:center;">
        <label for="verification_code" style="font-weight:500;margin:0;">Enter OTP*</label>
        <div class="field" style="width:auto;">
          <input type="text" name="verification-code" id="verification_code" autocomplete="off" style="height:30px;width:100%;border:1px solid #ccc;outline:none;padding:0 6px;">
          <div class="{{$printable ? 'success' : 'error'}}">{{$message ?? ''}}</div>
        </div>
      </div>
      <p style="font-size:15px;">Click on validate button to validate OTP</p>
    </div>
    <div class="field" style="flex-direction:row;justify-content:flex-end;column-gap:6px;max-width:100%;padding:15px;">
      <button class="trp-btn" onclick="validateOTP()" id="validate">Validate</button>
      <button class="trp-btn" id="resend" onclick="sendRequest(true)" style="display:flex;align-items:center;column-gap:6px;">
        <img src="/resources/assets/loader.gif" alt="Loader" style="display:none;"/>
        Resend OTP
      </button>
      <button class="trp-btn" onclick="closeModel()">Close</button>
    </div>
  </div>
</div>
<script>
  function validateOTP()
  {
    $('input').removeClass('error').nextAll('.error').html('');
    $('.success').removeClass('success').addClass('error');
    $('#validate').attr('disabled', true);
    const data = {otp: $('#verification_code').val()};

    post('/verify_email', {data}).then(res => {
      if (res.error) {
        $(res.selector).addClass('error').focus().nextAll('.error').html(res.message);
      } else if (res.success) {
        alert('Verified Success!');
        closeModel();
      }
      $('#validate').attr('disabled', null);
    }).catch(err => {
      $('#validate').attr('disabled', null);
    });
  }
</script>