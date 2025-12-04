function manageOwner(uid)
{
  showLoader();
  const data = {disabled: $('#accountDisabled')[0].checked, uid};
  $('#BtnManager').attr('disabled', true);
  post('/admin/enabled_disable', {data}).then(res => {
    if (res.success) {
      sendOptRequest({url: '/admin/manage'});
      $('.response').html('');
      closeModel();
    } else {
      $('.response #content form').html(res);
    }
    $('#BtnManager').attr('disabled', null);
    hideLoader();
  }).catch(_err => {
    hideLoader();
    alert('Internal Server Error!');
    $('#BtnManager').attr('disabled', null);
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

function ManagePopup(disabled, uid)
{
  showModal();
  $('.response').html(
    `<div id="content" style="max-width:510px;">
      <div class="form-container">
        <div class="flex-box">
          <form style="width: 100%;padding:18px;">
            <label for="accountDisabled" style="user-select:none;margin-top:11px;">
              <span>Account Disabled</span>
              <input type="checkbox" id="accountDisabled" hidden>
              <div class="switch"></div>
            </label>
            <div class="group" style="justify-content:center;">
              <button type="button" id="btnSearch" onclick="closeModel()" style="font-size:12px;height:33px;">
                <i class="fa fa-times-circle"></i>
                &nbsp;CANCEL
              </button>
              <button type="button" style="color:#fff;font-size:12px;display:flex;align-items:center;justify-content:center;column-gap:6px;height:33px;" id="BtnManager" onclick="manageOwner(${uid})">
                <img class="preloader" src="/resources/assets/loader.gif" alt="Loader"/>
                <i class="fa fa-floppy-o"></i>
                <span>SUBMIT</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>`
  ).find('#accountDisabled')[0].checked = !!disabled;
}