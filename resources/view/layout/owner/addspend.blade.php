<style>#xcontent {background:#eee;}</style>
<div class="notice" style="margin-top:0;">
  <h3>Secretary Spent Amount Management Form / सचिव व्यय राशि प्रबंधन प्रपत्र</h3>
</div>
<div class="wrap bg">
  <div class="shaded">समग्र एकत्रित निधि का विवरण / Overall Collected fund Details</div>
  <form>
    <div class="group">
      <div class="field">
        <div style="font-size:14px;">Overall Collected Balance / कुल जमा राशि: ₹{{$overall_collection}}</div>
      </div>
      <div class="field">
        <div style="font-size:14px;">Last Collected Balance / अंतिम जमा राशि: ₹{{$collected}}</div>
      </div>
    </div>
  </form>
</div>
<div class="wrap bg">
  <div class="shaded">सचिव द्वारा खर्च की गई राशि का विवरण / Details of Secretary spent Amount</div>
  <form>
    <div class="p-status">
      <div class="status"></div>
    </div>
    <div class="group">
      <div class="field">
        <label for="spent_amount">Amount Spent / खर्च की गई राशि *</label>
        <input type="number" name="spent_amount" id="spent_amount" autocomplete="off" oninput="$('#output').text(this.value);$('#spent_amount, #afdvt').text(this.value);" form="registration_form">
        <div class="error"></div>
      </div>
      <div class="field">
        <label>Spent Amount Output:</label>
        <span>₹<span id="output"></span> खर्च की गई</span>
      </div>
    </div>
    <div class="group">
      <div class="field">
        <label for="describe">Where was it Spent / कहां खर्च किया गया *</label>
        <textarea name="describe" id="describe" cols="30" rows="6" style="outline:none;resize:none;border:1px solid #ced4da;padding: 8px 11px;font-family:inherit;border-radius:5px;" oninput="$('#output1').text(this.value);$('#describe').text(this.value);" form="registration_form"></textarea>
        <div class="error"></div>
      </div>
      <div class="field">
        <label>Where was it Spent Output:</label>
        <span>मैं प्रमाणित करता हूँ / करती हूँ कि हमने (<span id="output1"></span>) जिसमे (₹<span id="afdvt"></span>) खर्च की गई| मेरे द्वारा दी गयी विवरण सही है अर्थात किसी प्रकार का ग़लती होने पे मैं खुद जिम्मेदार रहूँगा/रहूंगी|</span>
      </div>
    </div>
  </form>
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
  <form style="padding:0;" id="registration_form" action="/owner/spent" onsubmit="registration(event)" method="post">
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
        <i class="fa fa-plus"></i>
        <span>Add Expense Record</span>
      </button>
      <button type="reset" style="padding:0 12px;width:max-content;display:flex;justify-content:center;align-items:center;column-gap:5px;background:#3c8dbc;">
        <i class="fa fa-refresh"></i>
        <span>Reset</span>
      </button>
    </div>
  </form>
</div>