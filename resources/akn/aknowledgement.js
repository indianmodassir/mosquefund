(function() {

const AKN_WIDTH = 2480;
const AKN_HEIGHT = 3508;
const PAGE_MARGIN = 140;

function Aknowledgement(options) {
  return new Aknowledgement.prototype.init(options || {});
}

Aknowledgement.prototype = {
  init: function(s) {
    this.uid = s.uid;
    this.fullname = s.fullname;
    this.email = s.email_address;
    this.number = s.number;
    this.district = s.district;
    this.block = s.block;
    this.village = s.village;
    this.request_date = s.request_date;
    this.approval_date = s.approval_date;
    return new Promise((resolve, reject) => this.generate(resolve, reject));
  },

  generate: async function(resolve, reject) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = AKN_WIDTH;
    canvas.height = AKN_HEIGHT;

    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';

    // Create a white page A4 size
    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, AKN_WIDTH, AKN_HEIGHT);

    // Create Rectangle Border
    ctx.strokeStyle = '#111111';
    ctx.lineWidth = 3;
    ctx.strokeRect(PAGE_MARGIN, PAGE_MARGIN, AKN_WIDTH - (PAGE_MARGIN * 2), AKN_HEIGHT - 1350);

    const imlogo = new Image();
    const weblogo = imlogo.cloneNode();

    imlogo.src = '/resources/akn/im.png';
    weblogo.src = '/resources/akn/logo.png';

    const HEADER_HEIGHT = 400;
    const HEADER_MARGIN = 70;

    imlogo.onload = () => {
      this.firstImageLoaded = true;
      ctx.drawImage(imlogo, PAGE_MARGIN + HEADER_MARGIN, PAGE_MARGIN + (HEADER_HEIGHT / 2) - 130, 130, 130);
    };

     weblogo.onload = () => {
      this.secondImageLoaded = true;
      ctx.drawImage(weblogo, AKN_WIDTH - (PAGE_MARGIN + HEADER_MARGIN + 180), PAGE_MARGIN + (((HEADER_HEIGHT - PAGE_MARGIN) - 180) / 2), 180, 180);
    };


    ctx.font = '700 38px sans-serif';
    ctx.fillStyle = '#3a5288';

    // 180 => 130 + 50 (130 Left logo width) + (40 Extra Margin)
    ctx.fillText('Mosque Fund Collection of Webapplication', PAGE_MARGIN + HEADER_MARGIN + 170, PAGE_MARGIN + HEADER_MARGIN + 55);

    ctx.font = '700 33px sans-serif';
    ctx.fillText('Develope by Indian Modassir', PAGE_MARGIN + HEADER_MARGIN + 170, PAGE_MARGIN + HEADER_MARGIN + 95);

    // Create a lable Header
    ctx.fillRect(PAGE_MARGIN + 10, HEADER_HEIGHT, AKN_WIDTH - ((PAGE_MARGIN + 10) * 2), 80);

    ctx.font = '700 60px sans-serif';
    ctx.textAlign = 'center';
    ctx.fillStyle = '#fff';
    ctx.fillText('Acknowledgement Slip - Online Secretary Registration', AKN_WIDTH / 2, HEADER_HEIGHT + 60);

    const details = {
      'Reference Number': this.uid,
      'Applicant Name': this.fullname,
      'Email Address': this.maskEmail(),
      'Mobile Number': this.maskNumber(),
      'District': this.district,
      'Post office/City': this.block,
      'Town/Village': this.village,
      'Registration Date': this.request_date,
      'Due Date': this.approval_date,
      'Time Period': '5 Days'
    };

    ctx.fillStyle = '#000000';
    ctx.font = '700 50px sans-serif';
    ctx.textAlign = 'start';

    let LH = 0; // Line Height
    
    for(let label in details) {
      ctx.fillText(label, PAGE_MARGIN + 33, PAGE_MARGIN + 480 + (LH * 110));
      ctx.fillText(':', PAGE_MARGIN + 1080, PAGE_MARGIN + 480 + (LH * 110));
      ctx.fillText(details[label], PAGE_MARGIN + 1380, PAGE_MARGIN + 480 + (LH * 110));
      LH++;
    }

    ctx.fillStyle = '#f1f1f1ff';
    ctx.fillRect(PAGE_MARGIN + 10, 1740, AKN_WIDTH - ((PAGE_MARGIN + 10) * 2), 200);

    ctx.fillStyle = '#000000';
    ctx.textAlign = 'center';
    ctx.fillText('Dear ' + this.fullname + ',', AKN_WIDTH / 2, 1830);
    ctx.fillText('Your secretary registration request has been sent to HOA Administrator.', AKN_WIDTH / 2, 1890);

    ctx.fillStyle = '#424242ff';
    ctx.font = '700 45px sans-serif';
    ctx.fillText('Electronically Generated, does not require Signature.', AKN_WIDTH / 2, 2130);

    ctx.strokeStyle = '#5a5959ff';
    ctx.lineWidth = 7;
    ctx.setLineDash([26, 22]);
    ctx.beginPath();
    ctx.moveTo(PAGE_MARGIN + 10, 1960);
    ctx.lineTo(AKN_WIDTH - PAGE_MARGIN, 1960);
    ctx.stroke();

    this.finalize(resolve, reject, canvas, AKN_WIDTH, AKN_HEIGHT, this.uid);
  },

  maskEmail: function() {
    const group = this.email.split('@');
    let value = group.shift();

    value = value.substring(0, 3) + ('*'.repeat(value.length - 3));
    return value + '@' + group;
  },

  maskNumber: function() {
    const number = String(this.number);
    return ('X'.repeat(number.length - 3)) + number.slice(-3);
  },

  finalize: function(resolve, reject, canvas, width, height, RefNo) {
    if (this.firstImageLoaded && this.secondImageLoaded) {
      resolve({
        image: canvas.toDataURL('image/jpeg', .8),
        width,
        height,
        RefNo
      });
    } else {
      setTimeout(() => this.finalize(resolve, reject, canvas, width, height, RefNo), 200);
    }
  }
};

Aknowledgement.prototype.init.prototype = Aknowledgement.prototype;
window.Aknowledgement = Aknowledgement;
})();