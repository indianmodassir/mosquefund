@php
function get(string $key, $vars) {
  return $vars[$key] ?? null;
}
@endphp
<div class="notice" style="margin-top:0;padding-top:33px;">
  <h4>पंजीकरण फॉर्म हेतु आवेदन-पत्र / Registration Form</h4>
  <h3>Application Form for Secretary Registration from Registered by Administrator (Indian Modassir)</h3>
  <br/>
</div>
<div class="wrap bg">
  <div class="shaded">आवेदक का विवरण / Details of Applicant</div>
  <form>
    <input type="hidden" name="csrf" value="{{get('csrf', $vars) ?? $csrf}}" autocomplete="off">
    <div class="p-status">
      <div class="status"></div>
    </div>
    <div class="group">
      <div class="field">
        <label for="fullname">Fullname of Applicant / आवेदक का नाम *</label>
        <input type="text" name="fullname" id="fullname" autocomplete="off" value="{{get('fullname', $vars)}}" oninput="$('#applicant').text(this.value);">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#fullname")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
      <div class="field">
        <label for="number">Mobile No. of Applicant *</label>
        <input type="text" name="number" id="number" value="{{get('number', $vars)}}" autocomplete="off">
        <div class="error"></div>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="email">Email Adress. of Applicant *</label>
        <input type="email" name="email" id="email" value="{{get('email_address', $vars)}}" autocomplete="off">
        <div class="error"></div>
      </div>
      <div class="field">
        <label for="district">जिला / District (In Hindi) *</label>
        <input type="text" name="district" id="district" value="{{get('district', $vars)}}" autocomplete="off">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#district")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="block">प्रखंड / Block (In Hindi) *</label>
        <input type="text" name="circle" id="block" value="{{get('block', $vars)}}" autocomplete="off">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#block")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
      <div class="field">
        <label for="village">ग्राम (Village) / मोहल्ला (Town) (In Hindi) *</label>
        <input type="text" name="village" id="village" value="{{get('village', $vars)}}" autocomplete="off">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#village")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
    </div>
  </form>
</div>

<div class="wrap bg">
  <div class="shaded">स्व-घोषणा / Self Declaration</div>
  <div class="box">
    <p style="font-size:14px;color:#666;">मैं  <span id="applicant"></span>, प्रमाणित करता/करती हूँ कि मेरे द्वारा दी गई उपरोक्त जानकारी मेरे ज्ञान और विश्वास के अनुसार सत्य है| यदि मेरे द्वारा दी गई जानकारी असत्य / गलत पायी जाती है तो मैं पूर्ण रूप से  जानता / जानती हूँ कि इस पंजीकरण आवेदन के आधार पर दिये गये उपयोगकर्ता आईडी और पासवर्ड के द्वारा वेबसाइट पर किया गया लॉग इन / खाते तक पहुंच या पंजीकरण अस्वीकार कर दिया जाएगा निरस्त कर दी जायेगी / कर दिया जायेगा अथवा उपयोगकर्ता अपना आईडी और पासवर्ड के आधार पर लॉग इन नहीं किया जा सकेगा और इस संबंध में विधि एवं नियमों के अधीन मेरे विरूद्ध की जाने वाली कार्रवाई या पंजीकरण अस्वीकार होने के लिए मैं उत्तरदायी रहूँगा / रहूँगी|</p>
  </div>
  <div class="checkwrap">
    <input type="checkbox" form="registration_form" name="declaration" id="declaration">
    <strong style="font-size:14px;">I Agree*</strong>
    <div class="error"></div>
  </div>
</div>

<div class="wrap bg">
  <form>
    <div class="label">
      <strong>Captcha verification</strong>
    </div>
    <div class="group" style="align-items: center; row-gap: 30px;">
      <div class="captcha" style="flex-direction:column;">
        <span>
          <canvas class="f-canvas" height="40" width="170"></canvas>
          <img src="resources/assets/refresh_icon.png" draggable="false" alt="Refresh" style="cursor: pointer;" onclick="generateCaptcha()">
        </span>
        <div style="margin-top:8px;font-size:14px;">Please enter the characters shown above</div>
      </div>
      <div class="captcha-input" style="position: relative;">
        <input form="registration_form" type="text" name="captcha" id="captcha" autocomplete="off" style="max-width:150px;">
        <div class="error"></div>
      </div>
    </div>
  </form>
</div>

<div class="wrap bg">
  <form style="padding:0;" id="registration_form" action="/request_registration" onsubmit="registration(event)" method="post">
    <div class="notice">
      <p>
        <p style="margin-bottom:8px;">Content on this website is owned, by the General Administration Department, Developer of Bihar</p>
        <p style="margin-bottom:8px;">Site is technically designed, hosted and maintained by Indian Modassir Developer (IMD)</p>
        <p>Powered By — IndianModassir</p>
      </p>
    </div>
    <div class="field" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;column-gap:8px;">
      <button style="padding:0 12px;width:max-content;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <img class="preloader" src="/resources/assets/loader.gif" draggable="false" alt="loader" width="17px">
        <i class="fa fa-location-arrow"></i>
        <span>Proceed</span>
      </button>
      <button type="reset" style="padding:0 12px;width:max-content;display:flex;justify-content:center;align-items:center;column-gap:5px;background:#3c8dbc;">
        <i class="fa fa-refresh"></i>
        <span>Reset</span>
      </button>
      <button onclick="window.close()" type="button" style="width:max-content;background:#e54a4a;padding:0 14px;">
        <i class="fa fa-times-circle"></i>
        <span>CLOSE</span>
      </button>
    </div>
  </form>
  <script>
    function sendRequest(printable)
    {
      const data = {email: $('#email').val(), name: $('#fullname').val(), printable: +printable || 0};

      $('input').removeClass('error').nextAll('.error').html('');
      $('#resend').attr('disabled', true);
      $('#resend img').show();
      showModal();

      post('/mail_verification_box', {data}).then(res => {
        if (res.body) {
          $('.response').html(res.body);
        } else if (res.error) {
          if (!res.selector) {
            alert(res.message);
          }
          $(res.selector).addClass('error').focus().nextAll('.error').html(res.message);
        } else if (res.success) {
          closeModel();
        }
        $('#resend').attr('disabled', null);
        $('#resend img').hide();
        if (!$('.response').text()) {
          closeModel();
        }
      }).catch(err => {
        $('#resend').attr('disabled', null);
        $('#resend img').hide();
        closeModel();
      });
    }
    $('#email').on('blur', ({target}) => {
      const value = target.value;
      const rEmail = /^(?=([a-z]+)([._0-9]+)?)[\w]{5,33}@(?=([a-z]+)([._0-9]+)?)[\w]{2,33}\.(?=([a-z]+)([._0-9]+)?)[\w]{2,5}$/;
      data = {email: value};
      if (rEmail.test(value)) {
         $('.response').html('');
        sendRequest();
      }
    });
  </script>
</div>