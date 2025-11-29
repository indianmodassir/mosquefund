<style>#xcontent {background:#eee;}</style>
<div class="notice" style="margin-top:0;padding-top:33px;">
  <h4>पंजीकरण फॉर्म हेतु आवेदन-पत्र / {{\ucwords($control)}} ({{$fullname}})</h4>
  <h3>Application Form for {{\ucwords($control)}} Registration from Registered by {{\ucwords($role)}} ({{$fullname}})</h3>
  <br/>
</div>
<div class="wrap bg">
  <div class="shaded">आवेदक का विवरण / Details of Applicant</div>
  <form>
    <div class="p-status">
      <div class="status"></div>
    </div>
    <div class="group">
      <div class="field">
        <label for="fullname">Fullname of Applicant / आवेदक का नाम *</label>
        <input type="text" name="fullname" id="fullname" autocomplete="off" oninput="$('#output').text(this.value);$('#applicant').text(this.value);" value="{{session()->get('fullname')}}" form="registration_form">
        <div class="error"></div>
        <div class="keyboard" onclick='kbdUI.open("#fullname")'>
          <img src="/resources/assets/keyboard.svg" alt="Keyboard" draggable="false">
        </div>
      </div>
      <div class="field">
        <label>Name of Applicant Output:</label>
        <span id="output">{{session()->get('fullname')}}</span>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="number">Mobile No. of Applicant *</label>
        <input type="text" name="number" id="number" value="{{session()->get('number')}}" autocomplete="off" form="registration_form">
        <div class="error"></div>
      </div>
      <div class="field">
        <label for="profile">Upload Profile. of Applicant *</label>
        <input type="file" name="profile" id="profile" value="{{session()->get('profile')}}" autocomplete="off" style="padding-top:6px;" accept="image/png, image/jpg, image/jpeg" form="registration_form">
        <div class="error"></div>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="amount">Last Paid Amount. of Applicant *</label>
        <input type="text" name="amount" id="amount" value="{{session()->get('amount') ?? 100}}" autocomplete="off" form="registration_form" oninput="$('#AmountOutput').text((+this.value).toLocaleString())">
        <div class="error"></div>
      </div>
      <div class="field">
        <label>Amount Output. of Applicant *</label>
        <span id="AmountOutput">{{session()->get('amount')}}</span>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="amount">Gender. of Applicant *</label>
        <select name="gender" id="gender" form="registration_form">
          <option value="0">--Select your Gender--</option>
          <option value="1">Male</option>
          <option value="2">Female</option>
          <option value="3">Other</option>
        </select>
        <div class="error"></div>
      </div>
      <div class="field">
        <label for="village">Village Name. of Applicant *</label>
        <input type="text" name="village" id="village" autocomplete="off" value="{{session()->get('village')}}" form="registration_form">
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
        <input type="text" name="captcha" id="captcha" autocomplete="off" style="max-width:150px;" form="registration_form">
        <div class="error"></div>
      </div>
    </div>
  </form>
</div>

<div class="wrap bg">
  <form style="padding:0;" id="registration_form" action="/member/registration1" onsubmit="registration(event, true)" enctype="multipart/form-data" method="post">
    <div class="notice">
      <p>
        <p style="margin-bottom:8px;">Content on this website is owned, by the General Administration Department, Developer of Bihar</p>
        <p style="margin-bottom:8px;">Site is technically designed, hosted and maintained by Indian Modassir Developer (IMD)</p>
        <p>Powered By — IndianModassir</p>
      </p>
    </div>
    <div class="field" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;">
      <button style="padding:0 12px;width:max-content;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <svg class="preloader" viewBox="0 0 19 19" fill="none" style=""><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square" style=""></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square" style=""></path></svg>
        <span>ADD MEMBER</span>
      </button>
    </div>
  </form>
</div>
<script>$('#AmountOutput').text($('#amount').val());</script>