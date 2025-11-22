<?php require 'components/header.php'; ?>
<style>body{display:flex;flex-direction:column;min-height:100vh;}footer *{ font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
footer{ margin-top:auto;padding: 0 15px; margin-top: auto; background: #f4f4fa;}
.foot{ padding: 22px 0; font-size: 15px; text-align: center; color: #7c7b7b; padding-bottom: 25px;}
.foot p{ line-height: 24px;}
footer i{ font-size: 22px;}
.flexbox strong{ font-weight: 600; font-size: 18px; color: #363232; padding-bottom: 8px; display: block;}
.flexbox{ padding-top: 50px; display: flex; flex-wrap: wrap; gap: 22px; justify-content: space-around;}
.flexbox a{ font-size: 15px; line-height: 30px; color: #4b4747; text-decoration: none;}
@media only screen and (max-width: 600px){.flexbox a{font-size:15px;font-weight:500;} .flexbox{ flex-direction: column; align-items: center; text-align: center;}.foot {font-size:13px;}.flexbox li strong {font-size:16px;}.col img {height:40px;}}
</style>
<div style="position:relative;width:100%">
  <img src="/resources/assets/mosque_banner1.jpg" alt="Banner" draggable="false" style="margin-top:55px;width:100%;">
</div>
<div class="section action">
  <strong>username</strong>
  <ul style="padding-bottom:0px;padding-top:18px;">
    <li style="text-align:start;" onclick="$('#rcpt_download')[0].click()">
      <div><img src="/resources/assets/download.svg" alt="Download" draggable="false"></div>
      <h2>Download Reciept</h2>
      <p>Click here to download digitally signed electronic copy of the Fee Reciept, using Fee Reciept Number (FRN).</p>
    </li>
    <li style="text-align:start;" onclick="$('#track_status')[0].click()">
      <div><img src="/resources/assets/track.svg" alt="Track Status" draggable="false"></div>
      <h2>Track Secretary Registration Status</h2>
      <p>Click here to check Secretary registration approval process and status, using Application Reference Number.</p>
    </li>
    <li style="text-align:start;" onclick="$('#check_reciept')[0].click()">
      <div><img src="/resources/assets/reciept.svg" alt="Reciept" draggable="false"></div>
      <h2>Check Member Reciept</h2>
      <p>Click here to check due, paid Fee details of specific month, using Application Reference Number.</p>
    </li>
    <li style="text-align:start;" onclick="$('#secretary')[0].click()">
      <div><img src="/resources/assets/registration.svg" alt="Registration" draggable="false"></div>
      <h2>Secretary Registration</h2>
      <p>Click here to new registration request for new secretary verify with personal email address (Mandantary).</p>
    </li>
    <li style="text-align:start;" onclick="$('#admin_login')[0].click()">
      <div>
        <img src="/resources/assets/admin.svg" alt="Admin" draggable="false">
      </div>
      <h2>Administrator Login</h2>
      <p>Click here to Login head Administrator of this website for web maintanance and Secretary data management.</p>
    </li>
    <li style="text-align:start;" onclick="$('#member_login')[0].click()">
      <div>
        <img src="/resources/assets/member.svg" alt="Member" draggable="false">
      </div>
      <h2>Member Login</h2>
      <p>Click here to Member login</p>
    </li>
    <li style="text-align:start;" onclick="$('#secretary_login')[0].click()">
      <div>
        <img src="/resources/assets/owner.svg" alt="Secretary" draggable="false">
      </div>
      <h2>Secretary Login</h2>
      <p>Click here to Secretary login</p>
    </li>
    <li style="text-align:start;" onclick="$('#collector_login')[0].click()">
      <div>
        <img src="/resources/assets/collector.svg" alt="Collector" draggable="false">
      </div>
      <h2>Collector Login</h2>
      <p>Click here to Collector login</p>
    </li>
  </ul>
</div>
<div class="section">
  <h1>Benefits</h1>
  <ul>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
    <li>
      <h2>Collector Login</h2>
      <p>Click here to download digitally signed and password protected electronic copy of the Aadhaar.</p>
    </li>
  </ul>
</div>
<footer>
  <div class="flexbox">
    <div class="col">
      <img src="/resources/assets/banner.png" alt="Banner" height="50px" draggable="false">
    </div>
    <ul class="col">
      <li id="contact"><strong>Social Links</strong></li>
      <li><a href="https://github.com/indianmodassir">Github</a></li>
      <li><a href="https://instagram.com/indianmodassir">Instagram</a></li>
      <li><a href="https://x.com/indianmodassir">Twitter</a></li>
    </ul>
    <ul class="col">
      <li><strong>Contact Us</strong></li>
      <li><a href="mailto:indianmodassir@gmail.com">indianmodassir@gmail.com</a></li>
      <li></li>
    </ul>
  </div>
  <div class="foot">
    <p>Made with In India | Empowering Mosque Fund Collection Digitally</p>
    <p>© 2025 Indian Modassir All Rights Reserved.</p>
  </div>
</footer>
<?php require 'components/footer.php'; ?>