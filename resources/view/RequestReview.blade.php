<style>tr td:first-child {max-width: fit-content}</style>
<div class="wrap bg" style="padding:11px;background:#fbfbfb;">
  <table class="f-review">
    <tr>
      <td colspan="2"><label>आवेदक का विवरण / Details of Applicant</label></td>
    </tr>
    <tr>
      <td>Fullname of Applicant *</td>
      <td>{{$fullname}}</td>
    </tr>
    <tr>
      <td>Mobile No. of Applicant *</td>
      <td>{{$number}}</td>
    </tr>
    <tr>
      <td>Email Adress. of Applicant *</td>
      <td><a href="{{$email_address}}">{{$email_address}}</a></td>
    </tr>
    <tr>
      <td>Registration Date *</td>
      <td>{{$request_date}}</td>
    </tr>
    <tr>
      <td>Email Verification *</td>
      <td>Verified</td>
    </tr>
    <tr>
      <td>जिला / District *</td>
      <td>{{$district}}</td>
    </tr>
    <tr>
      <td>प्रखंड / Block *</td>
      <td>{{$block}}</td>
    </tr>
    <tr>
      <td>ग्राम (Village) / मोहल्ला (Town) *</td>
      <td>{{$village}}</td>
    </tr>
    <tr>
      <td>Stree Address. of Applicant *</td>
      <td>{{\sprintf('VILL: %s, POST: %s, DIST: %s', $village, $block, $district)}}</td>
    </tr>
    <tr>
      <td>Approval Working Date *</td>
      <td>{{$working_date}} Days</td>
    </tr>
    <tr>
      <td>Approval Due Estimate Date *</td>
      <td>{{$approval_date}}</td>
    </tr>
  </table>
</div>
<div class="wrap bg" style="background:#fbfbfb;">
  <form action="/final_request" method="post" onsubmit="registration(event)" style="padding:0;">
    <div class="field btn-wrap" style="padding:12px 22px;flex-direction:row;justify-content:flex-end;max-width:100%;gap:6px;flex-wrap:wrap;">
      <button style="width:max-content;padding:0 14px;display:flex;justify-content:center;align-items:center;column-gap:5px;">
        <img class="preloader" src="/resources/assets/loader.gif" draggable="false" alt="loader" width="17px">
        <i class="fa fa-floppy-o"></i>
        <span>COMPLETE REGISTRATION</span>
      </button>
      <button type="button" data-type="edit" style="width:max-content;padding:0 14px;background:#3c8dbc;" data-action="/edit_registration" onclick="sendOptRequest(this)">EDIT DETAILS</button>
      <button data-action="/admin/dashboard" onclick="window.close()" type="button" style="width:max-content;background:#e54a4a;padding:0 14px;">
        <i class="fa fa-times-circle"></i>
        <span>CLOSE</span>
      </button>
    </div>
  </form>
</div>