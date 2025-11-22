function manageOwner(uid)
{
  showLoader();
  const data = {disabled: $('#accountDisabled')[0].checked, uid};
  post('/admin/enabled_disable', {data}).then(res => {
    if (res.success) {
      sendOptRequest({url: '/admin/manage'});
      $('.response').html('');
      closeModel();
    } else {
      $('.response #content form').html(res);
    }
    hideLoader();
  }).catch(_err => {
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
              <button type="button" id="btnSearch" onclick="closeModel()" style="font-size:12px;height:33px;">CANCEL</button>
              <button type="button" style="color:#fff;font-size:12px;display:flex;align-items:center;justify-content:center;column-gap:6px;height:33px;" id="btnPrint" onclick="manageOwner(${uid})">
                <img src="/resources/assets/loader.gif" alt="Loader" style="display:none;"/>
                <span>SUBMIT</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>`
  ).find('#accountDisabled')[0].checked = !!disabled;
}