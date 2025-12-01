function login({dataset}) {
  const role = dataset['login'];
  const csrf = dataset['csrf'];

  $('.login').addClass('hide');
  showModal();

  $.ajax({
    url: 'layout/Login',
    data: !csrf ? $('form').serialize() : {role, csrf}
  }).then((response) => {
    $('.response').html(response);
    $('form *').css('visibility', 'hidden');
    $('.captcha img').on('load', () => $('form *').css('visibility', ''));
    generateCaptcha();
  }).catch((err) => {
    $('.response').html(err);
  });
}

$(document).click(({target}) => {
  if (!$(target).parents().filter(".login-box").length) {
    $('.login').addClass('hide');
  }
});

function showModal() {
  $('html').css('overflow', 'hidden');
  $('dialog')[0].showModal();
}

function closeModel() {
  $('html').css('overflow', '');
  $('dialog')[0].close();
  $('dialog #content').remove();
}

function togglePassword(elem) {
  $(elem).toggleClass('show');
  const type = $('input[data-type=password], #otp').attr('type');
  $('input[data-type=password], #otp').attr('type', type === 'text' ? 'password' : 'text');
}

function generateCaptcha() {
  get('/captcha').then(({code}) => {
    const canvas = $('.captcha canvas')[0];
    const ctx = canvas.getContext('2d');

    canvas.width = 170;
    canvas.height = 40;

    /* Drawing Tild Lines */
    const angle = 30 * Math.PI / 180; // degree → radian conversion
    const lineSpacing = 13;           // distance between lines
    const lineLength = canvas.height * 2; // thoda zyada rakha taki puri cover kare

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.strokeStyle = '#3a3737ff';
    ctx.lineWidth = 3;

    for (let x = -lineLength; x < canvas.width + lineLength; x += lineSpacing) {
      ctx.beginPath();

      // Starting point (thoda upar se)
      const x1 = x;
      const y1 = canvas.height;

      // End point — 35 degree tilt ke according
      const x2 = x + Math.cos(angle) * lineLength;
      const y2 = y1 - Math.sin(angle) * lineLength;

      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.stroke();
    }
    /* End */

    ctx.font = '800 28px sans-serif';
    ctx.fillStyle = '#00cd06';
    ctx.imageSmoothingQuality = 'high';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.letterSpacing = '3px';
    ctx.fillText(code, canvas.width / 2, 21);
  });
}

// Authorization
function submitLoginForm(e) {
  e.preventDefault();
  const data = $('form').serialize();
  const form = e.target;
  $('input').removeClass('error').nextAll('.error').html('');
  $(':submit').attr('disabled', true);
  $('.b_error').html('');

  post(form.action, {data}).then((res) => {
    // Handle Mailing status
    if (res.field === '.status') {
      $('.status').addClass(res.status).html(res.response);

    // Error Handling
    } else if (res.error || res.selector === '.status') {
      !res.selector && alert(res.message);
      $(res.selector).addClass('error').focus().nextAll('.error').html(res.message);
      if (res.selector === '#search') $('.b_error').html(res.message);
      
      // Reset password input
      if (res.reset) {
        $('[name=password], #captcha').val('');
        generateCaptcha();
      }

    // Loads Response Template
    } else if (res.body) {
      $('.response').html(res.body);
      if (res.popup) ($('#search').val(''), showModal());
      !res.notCaptcha && generateCaptcha();
    } else if (res.download) {
      res.success = async (image, width, height, FRN) => {
        if (res.preview) {
          $('.response').html(res.html);
          $('#reciept_preview').attr('src', image);
        } else {
          const formData = new FormData();
          formData.append('height', height);
          formData.append('image', image);
          formData.append('width', width);
          
          const response = await fetch('routes/request', {
            method: 'POST',
            headers: {'request': '/generatepdf'},
            body: formData
          });

          // Reset Form and Captcha
          $('.form-container form')[0].reset();
          generateCaptcha();

          // Receive PDF blob and trigger download
          const blob = await response.blob();
          const url = URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.download = FRN;
          link.click();
          $(':submit').attr('disabled', null);
        }
      };
      Reciept(res);
    } else {
      window.location.reload();
    }

    !res.download && $(':submit').attr('disabled', null);
  }).catch(_ => {
    $(':submit').attr('disabled', null);
    alert('Internal Server Error!');
  });
}

// Loades Forgotten layout
function forgotPassword({dataset}) {
  const url = dataset['action'];

  const data = $('form').serialize();
  $('.response').html('');

  get(url, {data}).then((response) => {
    $('.response').html(response);
    generateCaptcha();
  }).catch(_err => {
    alert('Internal Server Error!');
  });
}

function sendOTP(url)
{
  $('input').removeClass('error').nextAll('.error').html('');
  $('.status').removeClass('success error').html('');
  $('#otpSender').attr('disabled', true);

  post(url || '/sendotp', {
    data: $('form').serialize()
  }).then((res) => {
    if (res.field) {
      if (res.field === '.status') {
        $('.status').addClass(res.status).html(res.response);
        $('[name=password]').focus();
      } else {
        !(res.selector || res.field) && alert(res.message);
        $(res.field).addClass('error').focus().nextAll('.error').html(res.response);
      }
    // For OTP send Successfully message!
    } else if (res.selector) {
      $('.status').html(res.message);
    }
    $('#otpSender').attr('disabled', null);
  }).catch(() => {
    $('#otpSender').attr('disabled', null);
  });
}

/**
 * Handle After logging
 */

function sendOptRequest(elem) {
  const url = $(elem).attr('data-action') || elem.url;
  $('.login').addClass('hide');
  $('#xcontent').html('');

  const component = url.split('/');
  const data = JSON.parse($('#info').val() || '[]');
  data.component = component.pop();
  data.role = component[1];
  data.control = $('#control').val();
  data.editable = $(elem).attr('data-type') ? 1 : 0;

  // Delete sensitive data
  delete data['frn'];
  delete data['otp'];
  delete data['password'];
  delete data['session'];
  delete data['id'];

  get(url, {
    data: data
  }).then((response) => {
    $('#xcontent').html(response.body || response);
    $('.f-canvas').length && generateCaptcha();
  }).catch(err => {
    $('#xcontent').html(err);
  });
}

function registration(event, isUpload, isCaptchaRefresh) {
  event.preventDefault();
  $('input, select').removeClass('error').nextAll('.error').html('');
  $('.status').removeClass('success error').html('');
  $(':submit').attr('disabled', true);

  let options = {
    url: 'routes/request',
    type: event.target.method,
    headers: {
      request: event.target.action
    },
    data: $('form').serialize()
  };

  if (isUpload) {
    options.processData = false;
    options.contentType = false;
    options.data = new FormData($('#registration_form')[0]);
  }

  $.ajax(options).then(res => {
    if (res.error) {
      isCaptchaRefresh && generateCaptcha();
      if (res.selector === '.status') {
        $('.status').addClass('error').html(res.message);
      } else {
        !res.selector && alert(res.message);
        $(res.selector).addClass('error').focus().nextAll('.error').html(res.message);
      }
    } else if (res.body) {
      $('#xcontent').html(res.body);
    }
    $(':submit').attr('disabled', null);
  }).catch(_error => {
    $(':submit').attr('disabled', null);
    alert('Internal Server Error!');
  });
}

function logout()
{
  post('/logout').then(res => {
    res.logged_out && window.location.reload();
  });
}

function openWindow() {
  let height = window.outerHeight;
  let width = window.outerWidth;

  height = height < 600 ? height - 80 : height - 240;
  width = width < 900 ? width - 50 : 990;
  
  window.open('track?stage=data_input', '_blank', `width=${width},height=${height},top=0,left=0,resizable=0,scrollbars=yes`);
}

/* HI-Keyboard Configure */