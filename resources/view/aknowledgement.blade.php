<style>#xcontent{padding:0!important;}.akn{ font-size: 12px;} .akn ul{ padding-left: 8px;} .akn ul li{ color: inherit; font-size: 10px; list-style: decimal;} .akn strong{ font-size: 15px; text-align:center; display: block;} .akn table td:first-child{ max-width: initial;} .akn table td{ white-space:nowrap;padding: 1px 0; font-size: inherit;} button{ border-radius: 5px; outline: none; padding: 4px 16px; cursor: pointer; color: #fff; font-size: 15px; display: flex; align-items: center; justify-content: center; column-gap: 6px; height: 38px; text-shadow: 0 1px 1px #000000; background: #7070fc; border: 1px solid #375dc5;} button:hover{ background: #6464e4;} #close:hover{background:#db3939;} #AknRcpt:not(:empty) + .aknloader {display: none;}
</style>
<div class="akn" id="cover" style="width:100%;min-height:100vh;background:#eee;padding:5% 11px;">
  <div style="overflow:auto;">
    <div style="background:#fff;max-width:800px;margin:0 auto;width:100%;" id="aknowledgement">
      <div class="akn-cover">
        <div id="AknRcpt"></div>
        <div class="aknloader" style="text-align:center;padding: 44px 0;">
          <img src="/resources/assets/loader_b.gif" alt="Loader" draggable="false">
        </div>
      </div>
      <ul style="padding:0px 22px 22px 30px;">
        <li>आवेदक अपना पंजीकरण का स्थिति जानने के लिए "ट्रैक स्टेटस" वाले बटन पे क्लिक करके अपना आवेदन संख्या डाल कर पंजीकरण का स्थिति देख सकता है.</li>
        <li>आवेदन पूरा होने पर, आवेदक के ईमेल पते पर यूज़र आईडी और पासवर्ड भेज दिया जाएगा, या आवेदक अपना पासवर्ड बदल सकता है। यदि आवेदन अस्वीकार कर दिया जाता है, तो आवेदक पुनः पंजीकरण करा सकता है।</li>
        <li>सेवा में देरी या किसी प्रकार की गड़बड़ी की शिकायत "हेल्पलाइन" के टॉल फ्री नं - +91 8969594390 पर की जा सकती है|</li>
      </ul>
    </div>
  </div>
  <div style="display:flex;justify-content:center;margin-top:44px;margin-bottom:33px;column-gap:8px;">
    <button onclick="exportReciept(this)" style="display:flex;justify-content:center;align-items:center;column-gap:5px;">
      <img class="preloader" src="/resources/assets/loader.gif" draggable="false" alt="loader" width="17px">
      <i class="fa fa-file-export"></i>
      Export Aknowledgement
    </button>
    <button onclick="window.close()" style="background:#e54a4a;" id="close">
      <i class="fa fa-times-circle"></i>
      Close
    </button>
  </div>
</div>
<script id="jsonData" type="application/json">{{$json}}</script>
<script src="/resources/akn/aknowledgement.js"></script>
<script>
  let Ximage, Xwidth, Xheight, XRefNo;
  Aknowledgement(JSON.parse($('#jsonData').text()))
  .then(({image, width, height, RefNo}) => {
    const img = document.createElement('img');

    Xheight = height;
    Ximage = image;
    Xwidth = width;
    XRefNo = RefNo;

    img.src = image;
    img.style.maxWidth = '100%';
    img.draggable = false;
    img.alt = 'Aknowledgement Reciept';
    $('#AknRcpt').append(img);
  });
  async function exportReciept(button) {
    if (!(Ximage && Xwidth && Xheight && XRefNo)) return;
    const formData = new FormData();
    formData.append('height', Xheight);
    formData.append('image', Ximage);
    formData.append('width', Xwidth);
    
    button.disabled = true;
    const response = await fetch('routes/request', {
      method: 'POST',
      headers: {'request': '/generatepdf'},
      body: formData
    });

    // Receive PDF blob and trigger download
    const blob = await response.blob();
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = XRefNo;
    link.click();
    button.disabled = false;
  }
</script>