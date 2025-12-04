<style>#xcontent {background:#eee;}</style>
<div class="notice" style="margin-top:0;padding-top:33px;">
  <h4>पंजीकरण फॉर्म हेतु आवेदन-पत्र / {{\ucwords($control)}} ({{$fullname}})</h4>
  <h3>Application Form for {{\ucwords($control)}} Registration from Registered by {{\ucwords($role)}} ({{$fullname}})</h3>
  <br/>
</div>
<div class="wrap bg">
  <div class="shaded">आवेदक का विवरण / Details of Applicant</div>
  <form>
    <div class="p-status" style="text-align:center;">
      <div class="status"></div>
    </div>
    <div class="group">
      <div class="field">
        <label for="fullname">Fullname of Applicant / आवेदक का नाम *</label>
        <input type="text" name="fullname" id="fullname" autocomplete="off" value="{{session()->get('fullname')}}" oninput="$('#applicant').text(this.value);">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#fullname")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
      <div class="field">
        <label for="number">Mobile No. of Applicant *</label>
        <input type="text" name="number" id="number" value="{{session()->get('number')}}" autocomplete="off">
        <div class="error"></div>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="email">Email Adress. of Applicant *</label>
        <input type="email" name="email" id="email" value="{{session()->get('email')}}" autocomplete="off">
        <div class="error"></div>
      </div>
      <div class="field">
        <label for="district">जिला / District *</label>
        <input type="text" name="district" id="district" value="{{session()->get('district')}}" autocomplete="off" oninput="makeAddress(this.value, 'district')">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#district")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="circle">प्रखंड / Block *</label>
        <input type="text" name="circle" id="circle" value="{{session()->get('circle')}}" autocomplete="off" oninput="makeAddress(this.value, 'post')">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#circle")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
      <div class="field">
        <label for="village">ग्राम (Village) / मोहल्ला (Town) *</label>
        <input type="text" name="village" id="village" value="{{session()->get('village')}}" autocomplete="off" oninput="makeAddress(this.value, 'village')">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#village")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="address">Street Address. of Applicant *</label>
        <textarea name="address" id="address" cols="30" rows="6" style="outline:none;resize:none;border:1px solid #ced4da;padding: 8px 11px;font-family:inherit;border-radius:5px;">{{session()->get('address')}}</textarea>
        <div class="error"></div>
      </div>
      <div class="field"></div>
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
        <input type="text" name="captcha" form="registration_form" id="captcha" autocomplete="off" style="max-width:150px;">
        <div class="error"></div>
      </div>
    </div>
  </form>
</div>

<div class="wrap bg">
  <form style="padding:0;" id="registration_form" action="/registration1" onsubmit="registration(event)" method="post">
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
        <i class="fa fa-floppy-o"></i>
        <span>SUBMIT</span>
      </button>
      <button type="reset" style="padding:0 12px;width:max-content;display:flex;justify-content:center;align-items:center;column-gap:5px;background:#3c8dbc;">
        <i class="fa fa-refresh"></i>
        <span>Reset</span>
      </button>
    </div>
  </form>
  <script>
    var address = {village: 'village: ' + $('#village').val(), post: 'post: ' + $('#circle').val(), district: 'district: ' + $('#district').val()};
    $('#address').val([
      'village: ' + $('#village').val(),
      'post: ' + $('#circle').val(),
      'district: ' + $('#district').val()
    ].join(', ').toUpperCase());
    function makeAddress(value, type) {
      address[type] = (type + ': ' + value);
      $('#address').val(Object.values(address).join(', ').toUpperCase());
    }
  </script>
</div>