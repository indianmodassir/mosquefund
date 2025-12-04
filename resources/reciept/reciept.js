(function() {

const RCPT_WIDTH = 1978;
const RCPT_HEIGHT = 999;
const BORDER_MARGIN = 10;
const PAGE_MARGIN = 70;

function Reciept(options) {
  return new Reciept.prototype.init(options || {});
}

Reciept.prototype = {
  init: function (s) {
    this.fullname = s.fullname;
    this.number = s.number;
    this.from = s.from;
    this.src = s.profile;
    this.to = s.to;
    this.district = s.district;
    this.circle = s.circle;
    this.village = s.village;
    this.place = s.place;
    this.contact = s.contact;
    this.dues = s.dues < 10 ? '0' + s.dues : s.dues || '00';
    this.paid = s.paid;
    this.frn = 'Fee Reciept No: ' + s.frn;
    this.date = 'Date: ' + s.date;
    this.signature = 'Digitally signed by ' + s.signature.toUpperCase();
    this.timestamp = 'Date ' + s.timestamp;
    this.address = `ग्राम / VILL: ${this.place}, POST: ${this.circle}, जिला / DIST: ${this.district}`;
    return new Promise((resolve, reject) => this.generate(resolve, reject));
  },

  generate: function(resolve, reject) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = RCPT_WIDTH;
    canvas.height = RCPT_HEIGHT;

    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';

    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, RCPT_WIDTH, RCPT_HEIGHT);

    // Create Rectangle Border
    ctx.strokeStyle = '#111111';
    ctx.lineWidth = 3;
    ctx.strokeRect(PAGE_MARGIN, PAGE_MARGIN, RCPT_WIDTH - (PAGE_MARGIN * 2), RCPT_HEIGHT - (PAGE_MARGIN * 2));

    ctx.lineWidth = 2;
    ctx.strokeRect(PAGE_MARGIN + BORDER_MARGIN, PAGE_MARGIN + BORDER_MARGIN, RCPT_WIDTH - ((PAGE_MARGIN + BORDER_MARGIN) * 2), RCPT_HEIGHT - ((PAGE_MARGIN + BORDER_MARGIN) * 2));

    // Signature Placeholder
    ctx.fillStyle = '#111111';
    ctx.font = '900 100px sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('چندہ براے مسجد', RCPT_WIDTH / 2, 190);

    ctx.font = '600 25px sans-serif';
    ctx.fillText(`जिला / District: ${this.district}, अंचल / Circle: ${this.circle}, ग्राम / Village: ${this.village}`, RCPT_WIDTH / 2, 245);
    ctx.textAlign = 'start';

    ctx.fillText(this.frn, 90, 350);
    ctx.fillText(this.date, RCPT_WIDTH - 285, 350);

    const watermark = new Image;
    watermark.src = '/resources/reciept/watermark.png';

    watermark.onload = async () => {
      ctx.globalAlpha = 0.4;
      ctx.drawImage(watermark, (RCPT_WIDTH - 750) / 2, 250, 750, 750);
      ctx.globalAlpha = 1;

      const profile = new Image;
      profile.src = this.src;
      profile.onload = () => {
        let naturalHeight = profile.naturalHeight;
        let naturalWidth = profile.naturalWidth;
        let profileWidth = 150;
        let profileHeight = profileWidth * (naturalHeight / naturalWidth);
        let profileX = RCPT_WIDTH - (profileWidth + PAGE_MARGIN + 22);
        ctx.drawImage(profile, profileX, 360, profileWidth, profileHeight);
        this.profileLoaded = true;
      };

      const extra_space = '\x20'.repeat(5);
      const space = '\x20'.repeat(10);
      const get = (key, isNum) => {
        return extra_space + (isNum ? '+91 ' : '') + this[key];
      };

      ctx.fillText('Name / नाम:' + get('fullname'), 90, 450);
      ctx.fillText('Mobile No / मोबाइल नं:' + get('number', true), (RCPT_WIDTH / 2) - 50, 450);
      ctx.fillText('Address / :' + get('address'), 90, 495);
      ctx.fillText('Paid From:' + get('from'), 90, 540);
      ctx.fillText('To:' + get('to'), 600, 540);

      /* Fill ... space */
      ctx.lineWidth = 2.5;
      ctx.setLineDash([6, 4]);
      ctx.beginPath();
      ctx.moveTo(235, 455);
      ctx.lineTo(920, 455);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(1200, 455);
      ctx.lineTo(1600, 455);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(224, 500);
      ctx.lineTo(1597, 500);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(224, 545);
      ctx.lineTo(594, 545);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(640, 545);
      ctx.lineTo(1000, 545);
      ctx.stroke();
      /* End */

      ctx.fillText(`बकाया राशि / Dues Amount ${space}: ₹ ${this.dues}/-`, 90, 610);
      ctx.fillText(`जमा राशि / Paid Amount ${space + extra_space}: ₹ ${this.paid}/-`, 90, 650);

      // Signature Placeholder
      ctx.fillStyle = '#111111';
      ctx.fillText('(हस्ताक्षर सचिव / Signature Secretary)', RCPT_WIDTH - 520, RCPT_HEIGHT - 120);

      // Digital Signature
      ctx.fillStyle = '#928d8dff';
      ctx.font = '18px sans-serif';

      const signature = this.signature;
      const timestamp = this.timestamp;
      const testText = signature.length > timestamp.length ? signature : timestamp;
      const SignWidth = ctx.measureText(testText).width;

      ctx.fillText(signature, RCPT_WIDTH - (SignWidth + PAGE_MARGIN + 50), 790);
      ctx.fillText(timestamp, RCPT_WIDTH - (SignWidth + PAGE_MARGIN + 50), 815);

      const QRData = ([
        `${this.frn}`,
        `${this.date}`,
        `Fullname: ${this.fullname}`,
        `state: Bihar`,
        `District: ${this.district}`,
        `PO/PS: ${this.circle}`,
        `place: ${this.place}`,
        `paid_from: ${this.from}`,
        `paid_to: ${this.to}`,
        `dues: ${this.dues}`,
        `paid: ${this.paid}`,
        `${this.signature}`,
        `Administrator: Indian Modassir`,
        `Contact: ${this.contact}`
      ]).join(",\x20\n");

      const QRCode = new Image();
      const QRAPI = 'https://api.qrserver.com/v1/create-qr-code/?size=370x370&data=' + QRData;
      const fetchQR = await fetch(QRAPI);
      const blob = await fetchQR.blob();
      const url = URL.createObjectURL(blob);
      QRCode.src = url;

      QRCode.onload = () => {
        ctx.drawImage(QRCode, 90, 690, 180, 180);
        this.QRLoaded = true;
      };

      ctx.fillStyle = '#111111';
      ctx.font = '20px sans-serif';
      ctx.fillText('किसी प्रकार की समस्या के लिए संपर्क करें Secretary Mobile No / सचिव मोबाइल नं. +91 ' + this.contact, 90, 900);

      this.finalize(resolve, reject, canvas, RCPT_WIDTH, RCPT_HEIGHT, this.frn);
    };
  },

  finalize: function(resolve, reject, canvas, width, height, frn) {
    if (this.profileLoaded && this.QRLoaded) {
      resolve({
        image: canvas.toDataURL('image/jpeg', .7),
        width,
        height,
        FRN: frn
      });
    } else {
      setTimeout(() => {
        this.finalize(resolve, reject, canvas, width, height, frn);
      }, 100);
    }
  }
};

Reciept.prototype.init.prototype = Reciept.prototype;
window.Reciept = Reciept;

})();