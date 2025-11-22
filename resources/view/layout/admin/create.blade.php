<style>#xcontent {background:#eee;}</style>
<div class="notice" style="margin-top:0;">
  <h3>{{\ucwords($control)}} Registration फॉर्म / Form-XII</h3>
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
    <div class="field" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;">
      <button style="padding:0 12px;width:max-content;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="currentColor" style="transform:rotateY(180deg)">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3572 3.23397C3.66645 2.97447 4.1014 2.92638 4.45988 3.11204L20.7851 11.567C21.1426 11.7522 21.3542 12.1337 21.322 12.5351C21.2898 12.9364 21.02 13.2793 20.6375 13.405L13.7827 15.6586L10.373 22.0179C10.1828 22.3728 9.79826 22.5789 9.39743 22.541C8.9966 22.503 8.65762 22.2284 8.53735 21.8441L3.04564 4.29872C2.92505 3.91345 3.04794 3.49346 3.3572 3.23397ZM5.67123 5.99173L9.73507 18.9752L12.2091 14.361C12.3304 14.1347 12.5341 13.9637 12.7781 13.8835L17.7518 12.2484L5.67123 5.99173Z" fill="currentColor"/>
        </svg>
        <span>SUBMIT</span>
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