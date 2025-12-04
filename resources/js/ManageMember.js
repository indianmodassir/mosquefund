let trGT = 0;
function fetchMemberInfo(target) {
  const uid = target.dataset['uid'];
  const fetchType = target.dataset['fetchType'];
  const data = {};

  data.uid = uid;
  data['fetch_type'] = fetchType;

  if (!(uid && fetchType)) return;
  showModal();

  post('/fetchmember', {data}).then(response => {
    $('.response').html(response);

    const totalRow = $('#payed tr').length;
    $('#payed tr:gt(4)').attr('hidden', true);
    trGT = 4;

    if (totalRow > 5) {
      $('#showMore').attr('hidden', null);
    }
  }).catch(_err => {
    alert('Internal Server Error!');
  });
}

function showMore() {
  $(`#payed tr[hidden]:lt(5)`).attr('hidden', null);
  if (!$('#payed tr[hidden]').length) {
    $('#showMore').attr('hidden', true);
  }
}

function confirmPayment(data, button)
{
  button.disabled = true;
  showLoader();
  post('/confirm_payment', {data}).then(response => {
    if (response.success) {
      $('.response').html('');
      closeModel();
      sendOptRequest({url: '/collector/all'});
    } else {
      button.disabled = false;
      alert(response.message);
    }
    button.disabled = false;
    hideLoader();
  }).catch(_err => {
    button.disabled = false;
    hideLoader();
    alert('Internal Server Error!');
  });
}

function showLoader()
{
  $('button img').css('display', 'flex');
}

function hideLoader()
{
  $('button img').css('display', 'none');
}

function openConfirmationPopup()
{
  $('#declaration').nextAll('.error').html('');
  const data = $('#paymentForm').serialize();

  if (!$('#declaration')[0].checked) {
    return $('#declaration').focus().nextAll('.error').html('Accept Terms & Conditions');
  }

  showDialog('payment', 'Are You Sure Confirm Payment', 'YES CONFIRM', 'confirmPayment', data);
}

function confirmDeleteMember(uid, button)
{
  button.disabled = true;
  post('/owner/delete', {data: {uid}}).then(res => {
    if (res.success) {
      $('.response').html('');
      closeModel();
      sendOptRequest({url: '/collector/all'});
    } else {
      button.disabled = false;
      alert(res.message);
    }
  }).catch(_err => {
    button.disabled = false;
    alert('Internal Server Error!');
  });
}

function deleteMember(elem)
{
  const uid = elem.dataset['uid'];
  showModal();
  showDialog('delete_member', 'Are You Sure Delete Member', 'YES DELETE', 'confirmDeleteMember', uid);
}

function showDialog(logo, label, btnText, handler, uid) {
  $('.response').html(
    `<div id="content" style="max-width:510px;">
      <div class="form-container">
        <div class="flex-box">
          <form style="width: 100%;padding:18px;">
            <img src="resources/assets/${logo}.png" alt="${logo}" style="max-width:130px;"/>
            <h2 style="margin-bottom:11px;color:#515966;text-align:center;">${label}</h2>
            <div class="group" style="justify-content:center;">
              <button type="button" id="btnSearch" onclick="closeModel()" style="font-size:14px;">
                <i class="fa fa-times-circle"></i>
                &nbsp;CANCEL
              </button>
              <button type="button" style="color:#fff;font-size:14px;display:flex;align-items:center;justify-content:center;column-gap:6px;" id="btnPrint" onclick="${handler}('${uid}', this)">
                <img src="/resources/assets/loader.gif" alt="Loader" style="display:none;"/>
                <i class="fa fa-floppy-o"></i>
                <span>${btnText}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>`
  );
}