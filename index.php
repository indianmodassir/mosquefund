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
<div style="position:relative;width:100%" class="section-top">
  <div style="display:flex;gap:44px;align-items:center;" class="btop">
    <div class="mosque-logo">
      <img src="/resources/assets/mosque.png" alt="Mosque" draggable="false" style="max-width:460px;width:100%;min-width:200px;">
    </div>
    <div class="middle-wrap">
      <div>
        <h1>Digitally manage of</h1>
        <h1>monthly mosque donations fund</h1>
        <h1>Webapplication</h1>
      </div>
      <div>
        <h1>Scan Now!</h1>
        <br/>
        <img src="/resources/assets/qrcode.png" alt="QR Code" draggable="false" width="100px">
      </div>
      <div>
        <h2>Share feedback at</h2>
        <h2>indianmodassir@gmail.com</h2>
      </div>
    </div>
  </div>
  <div class="login">
    <div class="box">
      <h2>Welcome to MosqueFund</h2>
      <br/>
      <img src="/resources/assets/owner.svg" alt="Secretary" width="160px" draggable="false">
      <br/>
      <div style="width:100%;">
        <button data-login="owner" data-csrf="<?=@csrf?>" onclick="login(this)">Secretary Login</button>
        <small>Login with Password and OTP</small>
      </div>
    </div>
  </div>
</div>
<div class="section action">
  <strong style="text-align:center;display:block;margin-top:33px;color:#22458a;">All Methods and Features / सभी विधियाँ और सुविधाएँ</strong>
  <ul style="padding-bottom:22px;padding-top:33px;">
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
      <p>Members and donors can login here to view their donation history, check any outstanding balance, and keep donations transparent.</p>
    </li>
    <li style="text-align:start;" onclick="$('#secretary_login')[0].click()">
      <div>
        <img src="/resources/assets/owner.svg" alt="Secretary" draggable="false">
      </div>
      <h2>Secretary Login</h2>
      <p>Authorized secretaries can login here to review donation records, monitor collectors, and oversee the mosque/community fund.</p>
    </li>
    <li style="text-align:start;" onclick="$('#collector_login')[0].click()">
      <div>
        <img src="/resources/assets/collector.svg" alt="Collector" draggable="false">
      </div>
      <h2>Collector Login</h2>
      <p>Authorized field collectors can login here to record house-to-house donations and submit all collected amounts securely.</p>
    </li>
  </ul>
</div>
<div class="section">
  <p style="text-align:center;font-size:15px;max-width:1260px;margin:0 auto;border: 1px solid #ccc;padding: 11px;">A Simple Online Platform for Transparent Chandah Management
    The Mosque Fund Management System is an online platform designed to manage chandah (donations) in a simple, organized, and transparent way. It helps the mosque or community center keep proper records of all donations, monitor collections, and allow members to see their own contribution history anytime.
    In many communities, chandah is collected door to door or directly in the mosque. Often, these amounts are written in notebooks or loose papers, which can easily be lost, damaged, or miscalculated. This website solves that problem by bringing the entire process into a secure online system that different roles can access according to their responsibility.
  </p>
</div>
<?php
  $secretries = count($auth_guard->secretries->toArray());
  $members = count($auth_guard->members->toArray());
  if ($secretries) {
    ?><div class="section">
      <strong style="text-align:center;display:block;margin-bottom:22px;color:#22458a;">All Connected Secretries and Members / सभी जुड़े सचिव और सदस्य</strong>
      <div class="group" style="max-width:100%;justify-content:space-around;align-items:center;padding-bottom:33px;">
        <div style="display:flex;align-items:center;column-gap:18px;">
          <img src="/resources/assets/owner.svg" alt="Secretary" width="100px" draggable="false">
          <h1 class="c-count" style="font-size:35px;">Secretries <?=$secretries;?></h1>
        </div>
        <div style="display:flex;align-items:center;column-gap:18px;">
          <img src="/resources/assets/member.svg" alt="Member" width="115px" draggable="false">
          <h1 class="c-count" style="font-size:35px;">Members <?=$members;?></h1>
        </div>
      </div>
    </div><?php
  }
?>
<br/>
<h3 style="text-align:center;display:block;margin-bottom:33px;color:#22458a;">Member/Donor Reciept Preview / सदस्य/दाता रसीद पूर्वावलोकन</h3>
<div class="section" style="background:#f4f4fa;padding:66px 18px;text-align:center;">
  <img src="/resources/assets/reciept.png" alt="Reciept" draggable="false" style="max-width:1080px;width:100%;box-shadow:0 4px 10px rgba(0, 0, 0, .3);border-radius:8px;">
</div>
<div class="section">
  <link rel="stylesheet" href="/resources/css/admin.css">
  <div class="find">
  <strong style="
    display: block;
    margin: 18px auto;
    color:#22458a;
    width: 100%;
    padding-bottom: 16px;
    padding-top: 44px;
    text-align: center;
  ">Overall Collection Details / समग्र संग्रह राशि का विवरण</strong>
  <form>
    <div style="
      display:flex;
      align-items:center;
      max-width: 550px;
      margin: 22px auto;
      position:relative;
    ">
      <div style="
        position:absolute;
        left: 11px;
        color: #999393;
        z-index: 1;
      ">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </div>
      <input type="number" name="number" id="search" autocomplete="on" placeholder="Secretary mobile number / सचिव का मोबाइल नंबर" style="
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
        padding: 0 11px 0 43px;
        height: 42px;
      ">
      <button type="button" style="
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        padding: 0 18px;
        height: 42px;
        white-space:nowrap;
        width: fit-content;
      ">Get Details</button>
    </div>
  </form>
  <br/><br/><br/><br/>
</div>
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
<div class="notice" style="margin-top:0;padding-top:33px;">
  <p style="margin-bottom:8px;">Content on this website is owned, by the General Administration Department, Developer of Bihar</p>
  <p style="margin-bottom:8px;">Site is technically designed, hosted and maintained by Indian Modassir Developer (IMD)</p>
  <p>Powered By — IndianModassir</p>
</div>
<?php require 'components/footer.php'; ?>