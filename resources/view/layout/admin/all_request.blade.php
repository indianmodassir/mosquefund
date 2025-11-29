<style>
  input, button {
    outline: none;
    padding: 0 8px;
    border: 1px solid #ced4da;
    border-radius: 4px;
  }
  button {
    padding: 0 15px;
    color: #fff;
    border: 1px solid #28a745;
    background: #28a745;
    text-shadow: 0 1px 1px #000000;
  }
  .view-data td {
    padding: 1px 0!important;
    font-size: 14px !important;
  }
  label {
    font-size: 13px;
  }
  input[type=radio] {
    padding: 0;
    transform: translateZ(0);
    backface-visibility: hidden;
    background-clip: padding-box;
    height: auto;
    font-size: initial;
    width: auto;
    border-radius: 0px;
    outline: none;
    border: 1px solid #ced4da;
  }
  textarea {
    outline: none;
    padding: 8px 11px;
    width: 100%;
    max-width: 500px;
    height: 100px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-family: inherit;
  }
</style>
<div class="group fixed" style="
  max-width: 100%;
  justify-content:flex-end;
  margin-bottom:18px;
  height: 38px;
  column-gap: 8px;
">
  <input type="number" id="reqId" autocomplete="off" oninput="reset(this.value)">
  <button onclick="filterRequest()" style="
    display: flex;
    justify-content: center;
    align-items: center;
    column-gap: 6px;
  ">
    <svg width="18px" height="18px" viewBox="0 0 24 24" fill="currentColor" style="transform: rotateY(180deg);">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3572 3.23397C3.66645 2.97447 4.1014 2.92638 4.45988 3.11204L20.7851 11.567C21.1426 11.7522 21.3542 12.1337 21.322 12.5351C21.2898 12.9364 21.02 13.2793 20.6375 13.405L13.7827 15.6586L10.373 22.0179C10.1828 22.3728 9.79826 22.5789 9.39743 22.541C8.9966 22.503 8.65762 22.2284 8.53735 21.8441L3.04564 4.29872C2.92505 3.91345 3.04794 3.49346 3.3572 3.23397ZM5.67123 5.99173L9.73507 18.9752L12.2091 14.361C12.3304 14.1347 12.5341 13.9637 12.7781 13.8835L17.7518 12.2484L5.67123 5.99173Z" fill="currentColor"></path>
    </svg>
    <span>Get Details</span>
  </button>
</div>
@if (count($requests))
<div style="overflow-y:hidden;">
  <table class="vtable" style="table-layout:initial;min-width:834px;">
    <tr>
      <th style="white-space:nowrap;width:0;">क्र० स०</th>
      <th>आवेदक का नाम</th>
      <th>आवेदक का मोबाइल</th>
      <th>आवेदक का ईमेल आईडी</th>
      <th>आवेदन संख्या</th>
      <th style="text-align:center;">विवरण देखें</th>
    </tr>
    @foreach($requests as $i => $request)
      <tr>
        <td>{{$i + 1}}</td>
        <td>{{$request['fullname']}}</td>
        <td>{{$request['number']}}</td>
        <td>{{$request['email']}}</td>
        <td class="reqid">{{$request['reqid']}}</td>
        <td style="text-align:center;"><a href="javascript:void(0)" style="font-size:inherit;" onclick='showData({{\json_encode($request)}})'>{{$request['approval'] == 1 ? 'Delivered' : ($request['approval'] == 0 ? 'Rejected' : 'Initiated')}}</a></td>
      </tr>
    @endforeach
  </table>
</div>
@else
  <h1 class="not-found">Request Not Found!</h1>
@endif
<h1 class="not-found" style="display:none;">Request Not Found!</h1>
<script>
  function reset(value) {
    if (!value) {
      $('.reqid').parent().show();
      $('.not-found').hide();
      $('.vtable').show();
    }
  }
  function filterRequest() {
    const expect_uid = $('#reqId').val().split('/').pop();
    if (!expect_uid) return;
    let matched = false;

    $('.reqid').each((_, el) => {
      const uid = $(el).text().split('/').pop();
      const tr = $(el).parent();
      expect_uid == uid ? ($(tr).show(), matched = true) : $(tr).hide();
    });

    matched ?
      ($('.not-found').hide(), $('.vtable').show())
      : ($('.not-found').show(), $('.vtable').hide());
  }

  function showData({
    approval_date,
    approval,
    circle,
    district,
    email,
    fullname,
    number,
    reqid,
    request_date,
    village,
    field_verification
  }) {
    let isResolved = field_verification == 1;
    showModal();
    $('.response').html(`
      <div id="content" class="tbl-content view-data" style="max-width:900px;">
        <div class="header">
          <button type="button" class="close" onclick="closeModel()" style="background:none;padding:0;box-shadow:none!important;">
            <span aria-hidden="true">×</span>
          </button>
          <h4>FIELD VERIFICATION / फील्ड सत्यापन</h4>
        </div>
        <div class="form-container">
          <form id="verificationForm" onsubmit="submitVerifyField(event)">
            <input type="hidden" name="number" value="${number}" autocomplete="off">
            <table class="tracker">
              <tr>
                <td colspan="2">
                  <label style="display:block;">आवेदक का विवरण / Details of Applicant</label>
                </td>
              </tr>
              <tr>
                <td>आवेदन की तिथि</td>
                <td>: ${request_date}</td>
              </tr>
              <tr>
                <td>सेवा प्रदान करने की समय अवधि</td>
                <td>: ${approval_date}</td>
              </tr>
              <tr>
                <td>आवेदन संख्या</td>
                <td>: ${reqid}</td>
              </tr>
              <tr>
                <td>आवेदक का नाम</td>
                <td>: ${fullname}</td>
              </tr>
              <tr>
                <td>आवेदक का मोबाइल नं</td>
                <td>: +91 ${number}</td>
              </tr>
              <tr>
                <td>आवेदक का ईमेल आईडी</td>
                <td>: ${email}</td>
              </tr>
              <tr>
                <td>आवेदक का जिला</td>
                <td>: ${district}</td>
              </tr>
              <tr>
                <td>पोस्ट / अंचल</td>
                <td>: ${circle}</td>
              </tr>
              <tr>
                <td>ग्राम / मोहल्ला</td>
                <td>: ${village}</td>
              </tr>
              <tr>
                <td>फील्ड सत्यापन स्थिति</td>
                <td>: ${isResolved ? "सत्यापित कर दिया गया ✓" : (field_verification == "" ? "प्रक्रिया के तहत ⟳" : "अस्वीकार कर दिया गया ✗")}</td>
              </tr>
              <tr>
                <td>पंजीकरण अनुमोदन स्थिति</td>
                <td>: ${approval == 1 ? "Delivered ✓" : (approval == "" ? "Initiated ⟳" : "Rejected ✗")}</td>
              </tr>
            </table>
          </form>
        </div>
      </div>`);
  }
</script>