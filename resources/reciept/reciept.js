(function() {

async function Reciept(options)
{
  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');

  let {
    fullname,
    signature,
    timestamp,
    date,
    frn,
    profile,
    domain,
    district,
    circle,
    village,
    place,
    number,
    paid,
    dues,
    contact,
    success
  } = options;

  const QRDetails = ([
    `FRNo: ${frn}`,
    `Date: ${date}`,
    `Fullname: ${fullname}`,
    `state: Bihar`,
    `District: ${district}`,
    `PO+PS: ${circle}`,
    `place: ${place}`,
    `dues: ${dues || '00'}`,
    `paid: ${paid}`,
    `Digital Signature: ${signature}`,
    `Administrator: Indian Modassir`,
    `Contact: ${contact}`
  ]).join("\x20\n");

  dues = dues || '00';
  date = 'दिनांक: ' + date;

  const pageMargin = 100;
  const w = 1978;
  const h = 2560;

  canvas.height = h;
  canvas.width = w;

  ctx.imageSmoothingEnabled = true;
  ctx.imageSmoothingQuality = 'high';

  // Clear Page
  ctx.fillStyle = '#FFFFFF';
  ctx.fillRect(0, 0, w, h);

  // Create Rectangle Border
  ctx.strokeStyle = '#333333';
  ctx.lineWidth = 3;
  ctx.strokeRect(pageMargin, pageMargin, w - (pageMargin * 2), h - 600);

  // Create Border Bottom line
  ctx.beginPath();
  ctx.strokeStyle = '#333333';
  ctx.moveTo(0, h - 108);
  ctx.lineTo(w, h - 108);
  ctx.lineWidth = 3;
  ctx.stroke();

  // Loads QRCode
  const QRCode = new Image();
  const QRAPI = 'https://api.qrserver.com/v1/create-qr-code/?size=370x370&data=' + QRDetails;
  const fetchQR = await fetch(QRAPI);
  const blob = await fetchQR.blob();
  const url = URL.createObjectURL(blob);
  QRCode.src = url;

  // Loads Watermark
  const watermark = new Image();
  watermark.src = '/resources/reciept/logo_light.png';
  watermark.onload = () => {
    ctx.globalAlpha = 0.4;
    ctx.drawImage(watermark, (w - 1200) / 2, 750, 1200, 1200);
    ctx.globalAlpha = 1;

    // Footer
    ctx.fillStyle = '#333333';
    ctx.font = '38px sans-serif';
    const footerText = `Fee Reciept No: ${frn} To View: ${domain} Mob: +91 ${contact}`;
    ctx.fillText(footerText, 80, h - 38);

    // Create FRN and Date between side
    ctx.font = '600 40px sans-serif';
    ctx.fillText('शुल्क रसीद संख्या: ' + frn, 120, 750);
    ctx.fillText(date, w - 450, 750);

    // 
    ctx.textAlign = 'center';
    ctx.fillText('दान रसीद-पत्र / Donation Receipt', w / 2, 540);
    ctx.fillText(`जिला / District: ${district}, अंचल / Circle: ${circle}, ग्राम / Village: ${village}`, w / 2, 600);
    ctx.textAlign = 'start';

    // Create Date and Address on QRCode
    ctx.font = '600 38px sans-serif';
    ctx.fillText('स्थान: ' + place, 120, 1520);
    ctx.fillText(date, 120, 1580);

    // Digital Signature
    ctx.fillStyle = '#928d8dff';
    ctx.font = '30px sans-serif';

    signature = 'Digitally signed by ' + signature.toUpperCase();
    timestamp = 'Date ' + timestamp;

    const testText = signature.length > timestamp.length ? signature : timestamp;
    const SignWidth = ctx.measureText(testText).width;

    ctx.fillText(signature, w - (SignWidth + pageMargin + 100), 1600);
    ctx.fillText(timestamp, w - (SignWidth + pageMargin + 100), 1640);

    // Signature Placeholder
    ctx.fillStyle = '#333333';
    ctx.font = '600 40px sans-serif';
    ctx.fillText('(हस्ताक्षर सचिव / Signature Secretary)', w - 800, 1800);

    const extra_space = '\x20'.repeat(5);
    const space = '\x20'.repeat(10);
    ctx.fillText(`बकाया राशि / Dues Amount ${space}: ₹ ${dues}/-`, 120, 1350);
    ctx.fillText(`जमा राशि / Paid Amount ${space + extra_space}: ₹ ${paid}/-`, 120, 1405);

    let message = `प्रमाणित किया जाता है कि (${fullname}), ग्राम / मोहल्ला - ${place}, थाना - ${circle}, प्रखंड - ${circle}, अनुमंडल - ${district}, जिला - ${district}, राज्य - बिहार एवं उनके तरफ से बराए मस्जिद के लिए दिया गया (दान / चंदा) तथा बकाया राशि निम्नांकित है :-`;

    let maxWidth = w - (pageMargin * 2); // Accurate Inside width
    let words = message.split(/([\x20\r\t\n])/);
    let word = '\x20'.repeat(13);
    let lines = [];

    maxWidth -= 40; // Given extra margin

    for(let i = 0; i < words.length; i++) {
      let testWidth = ctx.measureText(word).width;
      if (testWidth >= maxWidth) {
        word = word.split(/([\x20\r\t\n])/);
        let extraWord = word.pop() || '';
        lines.push(word.join(''));
        word = extraWord;
      }
      word += words[i];
    }

    if (word) lines.push(word);

    for(let i = 0; i < lines.length; i++) {
      const line = lines[i];
      ctx.fillText(line, 120, 1130 + (55 * i));
    }
  };

  // Define QRCode and Profile Image
  const image = new Image();
  const topLogo = new Image();
  
  image.src = profile;
  topLogo.src = '/resources/reciept/logo_dark.png';

  let profileLoaded, QRLoaded;
  
  // Loads Profile Image
  image.onload = () => {
    let naturalHeight = image.naturalHeight;
    let naturalWidth = image.naturalWidth;
    let profileWidth = 200;
    let profileHeight = profileWidth * (naturalHeight / naturalWidth);
    let profileX = w - (profileWidth + pageMargin + 15);

    ctx.drawImage(image, profileX, 770, profileWidth, profileHeight);
    profileLoaded = true;
  };

  QRCode.onload = () => {
    ctx.drawImage(QRCode, 120, 1610, 370, 370);
    QRLoaded = true;
  };

  topLogo.onload = () => {
    ctx.globalAlpha = 0.8;
    ctx.drawImage(topLogo, (w - 350) / 2, 110, 350, 350);
    
    function load() {
      if (profileLoaded && QRLoaded) {
        success(canvas.toDataURL('image/jpeg', .8), w, h, frn.toUpperCase());
      } else {
        setTimeout(load, 2000);
      }
    }
    load();
  }
}

window.Reciept = Reciept;

})();