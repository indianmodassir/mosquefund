<title>{{$uid}}</title>
<style>#xcontent{padding:0!important;}.akn{ font-size: 12px;} .akn ul{ margin-top: 22px;} .akn ul{ padding-left: 8px;} .akn ul li{ color: inherit; font-size: 10px; list-style: decimal;} .akn strong{ font-size: 15px; text-align:center; display: block;} .akn table td:first-child{ max-width: initial;} .akn table td{ white-space:nowrap;padding: 1px 0; font-size: inherit;} button{ border-radius: 5px; outline: none; padding: 4px 16px; cursor: pointer; color: #fff; font-size: 15px; display: flex; align-items: center; justify-content: center; column-gap: 6px; height: 38px; text-shadow: 0 1px 1px #000000; background: #7070fc; border: 1px solid #375dc5;} button:hover{ background: #6464e4;} #close:hover{background:#db3939;}
</style>
<div class="akn" id="cover" style="width:100%;min-height:100vh;background:#eee;padding:5% 11px;">
  <div style="overflow:auto;">
    <div style="background:#fff;max-width:800px;margin:0 auto;padding:22px;min-width:720px;" id="aknowledgement">
      <div style="border: 1px solid #524e4eff;outline:1px solid #524e4eff;outline-offset:2px;">
        <div style="
          margin-top: 5px;
          margin-bottom: 33px;
        ">
          <strong>Mosque Fund Collection</strong>
          <strong>फॉर्म / Form-VII</strong>
          <strong>(आवेदन का विवरण)</strong>
        </div>
        <div style="
          display:flex;
          justify-content:space-between;
          align-items:center;
          padding: 8px 6px;
          border-top: 1px solid #928d8dff;
          border-bottom: 1px solid #928d8dff;
        ">
          <div>आवेदक का पावती</div>
          <div>अनुरोध का प्रकार: पंजीकरण / Registration</div>
          <div>आवेदन की तिथि: {{$request_date}}</div>
        </div>

        <div style="padding:8px 6px;">
          <div>
            <table>
              <tr>
                <td>सेवा का नाम</td>
                <td>: सचिव पंजीकरण / Secretary Registration</td>
              </tr>
              <tr>
                <td>जारीकर्ता का नाम</td>
                <td>: प्रशासक (Indian Modassir)</td>
              </tr>
              <tr>
                <td>आवेदन संख्या</td>
                <td>: {{$uid}}</td>
              </tr>
              <tr>
                <td>आवेदक का नाम</td>
                <td>: {{$fullname}}</td>
              </tr>
              <tr>
                <td>मोबाइल</td>
                <td>: {{$number}}</td>
                <td>ईमेल आईडी</td>
                <td>: {{$email_address}}</td>
              </tr>
              <tr>
                <td>जिला</td>
                <td>: {{$district}}</td>
                <td>पोस्ट / अंचल</td>
                <td>: {{$block}}</td>
              </tr>
              <tr>
                <td>ग्राम / मोहल्ला</td>
                <td>: {{$village}}</td>
                <td>सेवा प्रदान करने की तिथि</td>
                <td>: {{$approval_date}}</td>
              </tr>
              <tr>
                <td>सेवा प्रदान करने की समय अवधि</td>
                <td>: (05 कार्य दिवस)</td>
                <td>ईमेल सत्यापन</td>
                <td>: सत्यापित किया गया</td>
              </tr>
            </table>
          </div>
          <div style="display:flex;justify-content:flex-end;margin:6px 0;">
            <div>
              <img src="/resources/assets/signature.jpg" alt="Signature" draggable="false" width="80px">
              <div style="font-weight:600;">प्रशासक हस्ताक्षर</div>
            </div>
          </div>
        </div>

        <div style="
          padding-top: 14px;
          padding-bottom: 4px;
          padding-left: 11px;
          padding-right: 11px;
          font-size: 10.5px;
          border-top: 1px solid #928d8dff;
        ">नोट :- * समय सीमा के अधीन सेवा प्राप्त नही होने पर प्रशासक के समक्ष 7 दिवस के अंदर रिपोर्ट किया जा सकता है|</div>
      </div>
      <ul>
        <li>आवेदक अपना पंजीकरण का स्थिति जानने के लिए "ट्रैक स्टेटस" वाले बटन पे क्लिक करके अपना आवेदन संख्या डाल कर पंजीकरण का स्थिति देख सकता है.</li>
        <li>आवेदन पूरा होने पर, आवेदक के ईमेल पते पर यूज़र आईडी और पासवर्ड भेज दिया जाएगा, या आवेदक अपना पासवर्ड बदल सकता है। यदि आवेदन अस्वीकार कर दिया जाता है, तो आवेदक पुनः पंजीकरण करा सकता है।</li>
        <li>सेवा में देरी या किसी प्रकार की गड़बड़ी की शिकायत "हेल्पलाइन" के टॉल फ्री नं - +91 8969594390 पर की जा सकती है|</li>
      </ul>
    </div>
  </div>
  <div style="display:flex;justify-content:center;margin-top:18px;margin-bottom:33px;column-gap:8px;">
    <button onclick="setBG(true);Print(document.querySelector('#aknowledgement'), true);setBG();">Export Aknowledgement</button>
    <button onclick="window.location.replace('/Reg8Yecd')" style="background:#e54a4a;" id="close">Close</button>
  </div>
</div>
<script>
  function setBG(light) {
    var elem = document.getElementById('cover');
    var bg = light ? '#fff' : '#eee';
    document.body.background = bg;
    elem.style.background = bg;
  }
</script>
<script src="/resources/js/print.min.js"></script>